<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lista;
use App\Models\Unsubscribe;
use App\Mail\Unsubscribe as UnsubscribeMail;
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

        $listas = Lista::where('emails', 'LIKE', '%'.$request->email.'%')->get();
        $unsubscribed_listas = Unsubscribe::where('email', 'LIKE', '%'.$request->email.'%')->get();
        if(sizeof($listas) == 0 && sizeof($unsubscribed_listas) == 0){
            $request->session()->flash('alert-danger','O email '.$request->email.' não consta em nenhuma lista.');
            return redirect('/');
        }

        $unsubscribe_link = URL::temporarySignedRoute('unsubscribe', now()->addMinutes(120), [
            'email' => $request->email,
        ]);
        
        Mail::send(new UnsubscribeMail($request->email, $unsubscribe_link));
        $request->session()->flash('alert-info','Para continuar com o gerenciamento de insrições, por favor, consulte sua caixa de entrada ou spam em seu email.');
        return redirect('/');
    }

    public function index(Request $request)
    {
        if ($request->hasValidSignature()) {

            $request->validate([
                'email' => 'required|email'
            ]);
            
            $unsubscribed_listas = \DB::table('listas')
                ->join('unsubscribes', 'listas.id', '=', 'unsubscribes.id_lista')
                ->where('unsubscribes.email', 'LIKE', '%'.$request->email.'%')
                ->get(['listas.id', 'listas.description', 'listas.name','unsubscribes.motivo' ]);
            
            $id_unsubscribed_listas = array_column(@json_decode(json_encode($unsubscribed_listas), true), 'id');
            $listas = Lista::where('emails', 'LIKE', '%'.$request->email.'%')->whereNotIn('id', $id_unsubscribed_listas)->get();
            
            
            $unsubscribe_form_action = URL::temporarySignedRoute('unsubscribe_request', now()->addMinutes(120));

            return view('subscriptions.listas',[
                'listas' => $listas,
                'unsubscribed_listas' => $unsubscribed_listas,
                'email'  => $request->email,
                'form_action' => $unsubscribe_form_action
            ]);
           
        } else {
            $request->session()->flash('alert-danger',
                "Url de gerenciamento de inscrição expirada, por favor, crie uma url nova.");
            return redirect('/');
        }
    }


    public function unsubscribe(Request $request){
        
        if ($request->hasValidSignature()) {
            $request->validate(['email' => 'required|email']);
            
            $unsubscribed_listas = Unsubscribe::where('email', 'LIKE', '%'.$request->email.'%')->get()->toArray();
            
            $unsubscribed_listas = array_column($unsubscribed_listas, 'id_lista');
            
            $listas = $request['id_lista'] ?? [-1];
            
            $remove_unsubscribe = Unsubscribe::where('email', 'LIKE', '%'.$request->email.'%')->whereNotIn('id_lista', $listas)->get(['id', 'id_lista'])->toArray();
          
            foreach($remove_unsubscribe as $remove){
                Unsubscribe::where('id', $remove['id'])->delete();
                //Mailman::emails(Lista::where('id', $remove['id_lista'])->get()->first());//atualiza os emails da lista --> TEM QUE MELHORAR A PERFORMANCE

                $request->session()->flash('alert-success','Alterações feitas com sucesso!');
            }
           
            foreach($listas as $l){   
                if($l == -1){
                    return redirect('/');
                }            
                $lista = Lista::where('id', (int)$l)->get()->first();        
                if($lista == null){
                    $request->session()->flash('alert-danger','Ocorreu um erro durante a desinscrição, lista não encontrada.');
                    return redirect('/');
                }
                $unsubscribe = Unsubscribe::firstOrCreate(
                    ['id_lista' => (int)$l,
                    'email'    => $request->email]
                );
               
                $unsubscribe->motivo = $request['motivo'.$l];
                $unsubscribe->save();
        
                //Mailman::emails($lista);//atualiza os emails da lista --> TEM QUE MELHORAR A PERFORMANCE 
            }
            $request->session()->flash('alert-success','Alterações feitas com sucesso!');
            return redirect('/');
        } else {
            $request->session()->flash('alert-danger',
                "Url expirada. Tente Novamente");
            return redirect('/subscriptions');
        }
        
    }

}
