<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lista;
use Illuminate\Support\Facades\URL;

class SubscriptionController extends Controller
{
    public function form(Request $request)
    {
        $this->authorize('authorized');
        return view('subscriptions/form');
    }

    public function listas(Request $request)
    {
        $this->authorize('authorized');

        $request->validate([
            'email' => 'required|email'
        ]);

        $listas = Lista::where('emails', 'LIKE', '%'.$request->email.'%')->get();

        return view('subscriptions.listas',[
            'listas' => $listas,
            'email'  => $request->email,
        ]);
    }

    public function unsubscribe_request(Request $request, Lista $lista, $email){

        $unsubscribe = URL::temporarySignedRoute('unsubscribe', now()->addMinutes(120), [
            'lista' => $lista->id,
            'email' => $email,
        ]);

        #Mail::send(new UnsubscribeMail($unsubscribe,$lista,$email));
        $request->session()->flash('alert-info','Informações para sair da lista enviadas por email');
        dd($unsubscribe);
        return redirect('/');
    }

    public function unsubscribe(Request $request, Lista $lista, $email){
        if ($request->hasValidSignature()) {
            dd('TODO: processar remocão');
            return redirect('/');
        } else {
            $request->session()->flash('alert-danger',
                "Url expirada. Tente Novamente");
            return redirect('/subscriptions');
        }
        
    }

}
