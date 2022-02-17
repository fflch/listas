<?php

namespace App\Http\Controllers;

use App\Models\Lista;
use Illuminate\Http\Request;
use splattner\mailmanapi\MailmanAPI;
use Uspdev\Replicado\DB;
use App\Utils\Utils;
use App\Utils\Mailman;
use App\Http\Requests\ListaRequest;

class ListaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('admin');
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
        $this->authorize('admin');
        $lista = new Lista;
        return view('listas/create', compact('lista'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ListaRequest $request)
    {
        $this->authorize('admin');
        $lista = Lista::create($request->validated());
       
        // Salva as consultas relacionadas à lista
        $lista->consultas()->sync($request->replicado_query);
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
        $this->authorize('authorized');
        return view("listas/show",[
            'lista' => $lista,
            #'titles' => Mailman::getArchive($lista)
            'titles' => ['Ainda não implementado']
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
        $this->authorize('admin');
       return view("listas/edit",compact('lista'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lista  $lista
     * @return \Illuminate\Http\Response
     */
    public function update(ListaRequest $request, Lista $lista)
    {
        $this->authorize('admin');
        $lista->update($request->validated());
       
        //Salva as consultas relacionadas à lista
        $lista->consultas()->sync($request->replicado_query);
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
        $this->authorize('admin');
        $lista->delete();
        return redirect('/listas');
    }

    public function mailman(Request $request, Lista $lista)
    {
        $this->authorize('admin');
        if($request->mailman == 'emails') {
            $hasError = Mailman::emails($lista);
            if($hasError){
                $request->session()->flash('alert-warning',"Emails atualizados com sucesso, exceto os emails da fonte externa. Ocorreu um erro durante a requisição, verifique se a url e o token estão corretos. Detalhes do erro: " . $hasError);
            }else{
                $request->session()->flash('alert-success',"Emails da lista atualizados com sucesso");
            }
        }

        if($request->mailman == 'config') {
            Mailman::config($lista);
            $request->session()->flash('alert-success',"Lista atualizada com sucesso");
        }
        
        return redirect("/listas/$lista->id");
    }
    
}
