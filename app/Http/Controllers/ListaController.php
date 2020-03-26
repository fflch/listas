<?php

namespace App\Http\Controllers;

use App\Lista;
use Illuminate\Http\Request;
use splattner\mailmanapi\MailmanAPI;
use Uspdev\Replicado\DB;

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
            'description'     => 'required',
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
            'description'     => 'required',
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

    public function updateMailman(Request $request, Lista $lista)
    {
        if(empty($lista->url_mailman)){
            $request->session()->flash('alert-danger', "Mailman não configurado nessa lista");

            return redirect("/listas/$lista->id");
        }
        $url = $lista->url_mailman . '/' . $lista->name;
        $mailman = new MailmanAPI($url,$lista->pass,false);

        /* Emails da lista */
        $emails_mailman = $mailman->getMemberlist();

        /* Emails do replicado */
        $result = DB::fetchAll($lista->replicado_query);
        $emails_replicado = array_column($result, 'codema');
        
        /* Emails que estão no replicado, mas não na lista
         * Serão inseridos na lista         
         */
        $to_add = array_diff($emails_replicado,$emails_mailman);

        /* Emails que estão na lista, mas não no replicado
         * Serão removidos na lista
         */
        $to_remove = array_diff($emails_mailman,$emails_replicado);

        $mailman->removeMembers($to_remove);
        $mailman->addMembers($to_add);

        $request->session()->flash('alert-success', 
            count($to_remove) . " emails removidos e " .
            count($to_add) . " adicionados.");

        return redirect("/listas/$lista->id");
    }

}
