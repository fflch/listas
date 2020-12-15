<?php

namespace App\Http\Controllers;

use App\Models\Lista;
use Illuminate\Http\Request;
use splattner\mailmanapi\MailmanAPI;
use Uspdev\Replicado\DB;
use Uspdev\Cache\Cache;
use App\Rules\MultipleEmailRule;
use App\Utils\Utils;
use App\Utils\Mailman;

class ListaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->middleware('can:admin');
        $listas = Lista::all();
        return view('listas/index',compact('listas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->middleware('can:admin');
        $lista = new Lista;
        return view('listas/create', compact('lista'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->middleware('can:admin');
        // Validações
        $request->validate([
            'description'     => 'required',
            'emails_allowed' => [new MultipleEmailRule],
            'emails_adicionais' => [new MultipleEmailRule],
            'url_mailman' => 'required',
            'pass' => 'required',
        ]);
        $lista = new Lista;
        $lista->name = $request->name;
        $lista->url_mailman = $request->url_mailman;
        $lista->description = $request->description;
        $lista->pass = $request->pass;
        $lista->emails_allowed = Utils::trimEmails($request->emails_allowed);
        $lista->emails_adicionais = Utils::trimEmails($request->emails_adicionais);
        $lista->save();

        //Salva as consultas relacionadas à lista
        $lista->consultas()->sync($request->replicado_query);

        $request->session()->flash('alert-success', 'Lista cadastrada com sucesso!');
        return redirect("/listas/{$lista->id}");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lista  $lista
     * @return \Illuminate\Http\Response
     */
    public function show(Lista $lista)
    {
        return view("listas/show",[
            'lista' => $lista,
            'titles' => Mailman::getArchive($lista)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lista  $lista
     * @return \Illuminate\Http\Response
     */
    public function edit(Lista $lista)
    {
       $this->middleware('can:admin');
       return view("listas/edit",compact('lista'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lista  $lista
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lista $lista)
    {
        $this->middleware('can:admin');
        // Validações
        $request->validate([
            'description'     => 'required',
            'replicado_query' => 'required',
            'emails_allowed' => [new MultipleEmailRule],
            'emails_adicionais' => [new MultipleEmailRule],
        ]);

        $lista->name = $request->name;
        $lista->url_mailman = $request->url_mailman;
        $lista->description = $request->description;
        $lista->pass = $request->pass;
        $lista->emails_allowed = Utils::trimEmails($request->emails_allowed);
        $lista->emails_adicionais = Utils::trimEmails($request->emails_adicionais);
        $lista->save();

        //Salva as consultas relacionadas à lista
        $lista->consultas()->sync($request->replicado_query);
        
        $request->session()->flash('alert-success', 'Lista atualizada com sucesso!');
        return redirect("/listas/{$lista->id}");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lista  $lista
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lista $lista)
    {
        $this->middleware('can:admin');
        /*
        $lista->consultas()->detach();
        $lista->delete();
        return redirect('/listas');
        */
        die("Not implemented");
    }

    public function mailman(Request $request, Lista $lista)
    {
        $this->middleware('can:admin');
        if($request->mailman == 'emails') {
            Mailman::emails($lista);
            $request->session()->flash('alert-success',"Lista atualizada com sucesso");
        }

        if($request->mailman == 'config') {
            Mailman::config($lista);
            $request->session()->flash('alert-success',"Lista atualizada com sucesso");
        }
        
        return redirect("/listas/$lista->id");
    }
    
}
