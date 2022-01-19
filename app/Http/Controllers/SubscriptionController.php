<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lista;
use App\Models\Unsubscribe;
use Illuminate\Support\Facades\URL;

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

        $unsubscribe = URL::temporarySignedRoute('unsubscribe', now()->addMinutes(120), [
            'email' => $request->email,
        ]);
        dd($unsubscribe);
        #Mail::send(new UnsubscribeMail($unsubscribe,$lista,$email));
        $request->session()->flash('alert-info','Informações para sair da lista enviadas por email');
        
       
    }

    public function index(Request $request)
    {
        if ($request->hasValidSignature()) {

            $request->validate([
                'email' => 'required|email'
            ]);
            $listas = Lista::where('emails', 'LIKE', '%'.$request->email.'%')->get();

            return view('subscriptions.listas',[
                'listas' => $listas,
                'email'  => $request->email,
            ]);
           
        } else {
            $request->session()->flash('alert-danger',
                "Url de desincrição expirada, crie uma url nova!");
            return redirect('/');
        }
    }


    public function unsubscribe(Request $request, Lista $lista, $email){
        if ($request->hasValidSignature()) {
            $unsubscribeModel = Unsubscribe::where('email',$email)->where('id_lista', $lista->id)->first();
            if(!$unsubscribeModel) $unsubscribeModel = new Unsubscribe;
            $unsubscribeModel->email = $email;
            $unsubscribeModel->id_lista = $lista->id;
            $unsubscribeModel->save();
            $request->session()->flash('alert-success','Email removido da lista com sucesso');
            return redirect('/');
        } else {
            $request->session()->flash('alert-danger',
                "Url expirada. Tente Novamente");
            return redirect('/subscriptions');
        }
        
    }

}
