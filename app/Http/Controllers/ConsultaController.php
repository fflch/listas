<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Http\Requests\ConsultaRequest;
use Illuminate\Http\Request;
use App\Utils\Mailman;

class ConsultaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('admin');
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
        $this->authorize('admin');
        return view('consultas/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConsultaRequest $request)
    {
        $this->authorize('admin');
        $validated = $request->validated();
        $consulta = Consulta::create($validated);
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
        $this->authorize('authorized');
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
        $this->authorize('admin');
        return view("consultas/edit",compact('consulta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Consulta  $consulta
     * @return \Illuminate\Http\Response
     */
    public function update(ConsultaRequest $request, Consulta $consulta)
    {
        $this->authorize('admin');
        $validated = $request->validated();
        $consulta->update($validated);
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
        $this->authorize('admin');
        $consulta->delete();
        return redirect('/consultas');
    }
}
