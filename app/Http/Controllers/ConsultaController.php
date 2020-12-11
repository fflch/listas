<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use Illuminate\Http\Request;
use App\Utils\Mailman;

class ConsultaController extends Controller
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
        $this->authorize('authorized');
        $consultas = Consulta::all();
        return view('consultas/index',compact('consultas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('consultas/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome'  => 'required',
            'replicado_query' => 'required',
        ]);
        $consulta = new Consulta;
        $consulta->nome = $request->nome;
        $consulta->replicado_query = $request->replicado_query;
        $consulta->save();
        $request->session()->flash('alert-success', 'Consulta cadastrada com sucesso!');
        return redirect("/consultas/{$consulta->id}");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Consulta  $consulta
     * @return \Illuminate\Http\Response
     */
    public function show(Consulta $consulta)
    {
        return view("consultas/show",[
            'consulta' => $consulta,
            'emails'   => Mailman::emails_replicado($consulta->replicado_query)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Consulta  $consulta
     * @return \Illuminate\Http\Response
     */
    public function edit(Consulta $consulta)
    {
        return view("consultas/edit",compact('consulta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Consulta  $consulta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Consulta $consulta)
    {
        $request->validate([
            'nome' => 'required',
            'replicado_query' => 'required',
        ]);
        $consulta->nome = $request->nome;
        $consulta->replicado_query = $request->replicado_query;
        $consulta->save();
        $request->session()->flash('alert-success', 'Consulta cadastrada com sucesso!');
        return redirect("/consultas/{$consulta->id}");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Consulta  $consulta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Consulta $consulta)
    {
        /*
        $consulta->listas()->detach();
        $consulta->delete();
        return redirect('/consultas');
        */
        die("Not implemented");
    }
}
