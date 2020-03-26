<?php

namespace App\Http\Controllers;

use App\Lista;
use Illuminate\Http\Request;

class ListaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        return view('listas/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validações
        $request->validate([
            'name'            => 'required',
            'url_mailman'     => 'required',
            'description'     => 'required',
            'pass'            => 'required',
            'emails_allowed'  => 'required',
            'replicado_query' => 'required',
        ]);

        $lista = new Lista;
        $lista->name = $request->name;
        $lista->url_mailman = $request->url_mailman;
        $lista->description = $request->description;
        $lista->pass = $request->pass;
        $lista->emails_allowed = $request->emails_allowed;
        $lista->replicado_query = $request->replicado_query;
        $lista->save();

        $request->session()->flash('alert-success', 'Lista cadastrada com sucesso!');
        return redirect()->route('listas.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lista  $lista
     * @return \Illuminate\Http\Response
     */
    public function show(Lista $lista)
    {
        return view("listas/show",compact('lista'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lista  $lista
     * @return \Illuminate\Http\Response
     */
    public function edit(Lista $lista)
    {
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
        // Validações
        $request->validate([
            'name'            => 'required',
            'url_mailman'     => 'required',
            'description'     => 'required',
            'pass'            => 'required',
            'emails_allowed'  => 'required',
            'replicado_query' => 'required',
        ]);

        $lista->name = $request->name;
        $lista->url_mailman = $request->url_mailman;
        $lista->description = $request->description;
        $lista->pass = $request->pass;
        $lista->emails_allowed = $request->emails_allowed;
        $lista->replicado_query = $request->replicado_query;
        $lista->save();

        $request->session()->flash('alert-success', 'Lista atualizada com sucesso!');
        return redirect()->route('listas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lista  $lista
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lista $lista)
    {
        die("Not implemented");
    }

    public function updateMailman(Lista $lista)
    {
      
    }
}
