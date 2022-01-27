<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lista;
use App\Models\Unsubscribe;
use App\Mail\Unsubscribe as UnsubscribeModel;
use Illuminate\Support\Facades\URL;
use App\Utils\Mailman;
use Illuminate\Support\Facades\Mail;

class SubscriptionController extends Controller
{
    public function create(Request $request)
    {
       
        return view('subscriptions/form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $unsubscribe_link = URL::temporarySignedRoute('unsubscribe', now()->addMinutes(120), [
            'email' => $request->email,
        ]);
        Mail::send(new UnsubscribeModel($request->email, $unsubscribe_link));
        $request->session()->flash('alert-info','Para continuar com a desisncrição da lista, por favor consulte sua caixa de entrada ou spam em seu email.');
        return redirect('/');
    }

    public function index(Request $request)
    {
        if ($request->hasValidSignature()) {

            $request->validate([
                'email' => 'required|email'
            ]);
            
            $unsubscribed_listas = Unsubscribe::where('email', 'LIKE', '%'.$request->email.'%')->get(['id_lista'])->toArray();
            $listas = Lista::where('emails', 'LIKE', '%'.$request->email.'%')->whereNotIN('id', array_column($unsubscribed_listas, 'id_lista'))->get();


            $unsubscribe_form_action = URL::temporarySignedRoute('unsubscribe_request', now()->addMinutes(120));

            return view('subscriptions.listas',[
                'listas' => $listas,
                'email'  => $request->email,
                'form_action' => $unsubscribe_form_action
            ]);
           
        } else {
            $request->session()->flash('alert-danger',
                "Url de desincrição expirada, crie uma url nova!");
            return redirect('/');
        }
    }


    public function unsubscribe(Request $request){
        
        if ($request->hasValidSignature()) {
            $request->validate([
                'id_lista' => 'required',
                'email' => 'required|email',
            ],
            [
                'id_lista.required' => 'Selecione ao menos uma lista para se desinscrever.'
            ]);
            
            $listas = $request['id_lista'];
            foreach($listas as $l){               
                $lista = Lista::where('id', (int)$l)->get()->first();        
                if($lista == null){
                    $request->session()->flash('alert-danger','Ocorreu um erro durante a desinscrição, lista não encontrada.');
                    return redirect('/');
                }
                $unsubscribe = Unsubscribe::firstOrCreate(
                    ['id_lista' => (int)$l,
                     'email'    => $request->email],
                    ['motivo'   => $request['motivo'.$l]]
                );
                
                Mailman::emails($lista);//atualiza os emails da lista
                $request->session()->flash('alert-success','Email removido da(s) lista(s) com sucesso!');
                return redirect('/');
            }
        } else {
            $request->session()->flash('alert-danger',
                "Url expirada. Tente Novamente");
            return redirect('/subscriptions');
        }
        
    }

}
