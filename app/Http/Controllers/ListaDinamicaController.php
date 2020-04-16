<?php

namespace App\Http\Controllers;

use App\ListaDinamica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Lista;
use splattner\mailmanapi\MailmanAPI;
use Uspdev\Replicado\DB;
use Uspdev\Cache\Cache;
use App\Rules\MultipleEmailRule;
use App\Utils;

class ListaDinamicaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('authorized');
        $listasDinamicas = ListaDinamica::all();
        return view('listas_dinamicas/index',compact('listasDinamicas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('admin');

        return view('listas_dinamicas/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('admin');

        // Validações
        $request->validate([
            'description'     => 'required',
            'name'            => 'required',
            'url_mailman'     => 'required',
            'pass'            => 'required',
            'emails_allowed' => [new MultipleEmailRule],
            'emails_adicionais' => [new MultipleEmailRule],
        ]);

        $listaDinamica = new ListaDinamica;
        $listaDinamica->description = $request->description;
        $listaDinamica->name = $request->name;
        $listaDinamica->url_mailman = $request->url_mailman;
        $listaDinamica->pass = $request->pass;
        $listaDinamica->emails_allowed = Utils::trimEmails($request->emails_allowed);

        $this->setConfigMailman($listaDinamica);
        $listaDinamica->save();

        $request->session()->flash('alert-success', 'Lista Dinâmica cadastrada com sucesso!');
        return redirect()->route('listas_dinamicas.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ListaDinamica  $listaDinamicaDinamica
     * @return \Illuminate\Http\Response
     */
    public function show(ListaDinamica $listasDinamica)
    {
        $this->authorize('authorized');
        $listaDinamica = $listasDinamica;
        $listas = [];
        if(!is_null($listasDinamica->listas_ids)){
            $listas_ids = explode(',',$listasDinamica->listas_ids);
            foreach($listas_ids as $lista_id){
                $lista = Lista::find($lista_id);
                $listas[$lista_id] = $lista;
            }
        }
        return view('listas_dinamicas/show',compact('listaDinamica','listas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ListaDinamica  $listaDinamicaDinamica
     * @return \Illuminate\Http\Response
     */
    public function edit(ListaDinamica $listasDinamica)
    {
        $this->authorize('admin');
        $listaDinamica = $listasDinamica;
        return view('listas_dinamicas/edit',compact('listaDinamica'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ListaDinamica  $listaDinamicaDinamica
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ListaDinamica $listasDinamica)
    {
        $this->authorize('admin');
        $listaDinamica = $listasDinamica;

        // Validações
        $request->validate([
            'description'     => 'required',
            'name'            => 'required',
            'url_mailman'     => 'required',
            'pass'            => 'required',
            'emails_allowed' => [new MultipleEmailRule],
            'emails_adicionais' => [new MultipleEmailRule],
        ]);

        $listaDinamica->description = $request->description;
        $listaDinamica->name = $request->name;
        $listaDinamica->url_mailman = $request->url_mailman;
        $listaDinamica->pass = $request->pass;
        $listaDinamica->emails_allowed = Utils::trimEmails($request->emails_allowed);

        $this->setConfigMailman($listaDinamica);
        $listaDinamica->save();

        $request->session()->flash('alert-success', 'Lista Dinâmica Atualizada com sucesso!');
        return redirect()->route('listas_dinamicas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ListaDinamica  $listaDinamicaDinamica
     * @return \Illuminate\Http\Response
     */
    public function destroy(ListaDinamica $listaDinamicaDinamica)
    {
        die('Please return! You can not do that!');
    }

    public function redefinirForm(Request $request, ListaDinamica $listaDinamica)
    {
        $this->authorize('authorized');
        $listas = Lista::all();
        return view('listas_dinamicas/redefinir',compact('listaDinamica','listas'));
    }

    public function redefinir(Request $request, ListaDinamica $listaDinamica)
    {
        $this->authorize('authorized');

        // Validações
        $request->validate([
            'emails_adicionais' => [new MultipleEmailRule],
        ]);

        /* Pega emails no replicado paras as coleções selecionadas */
        $emails = [];
        $cache = new Cache();

        if(!is_null($request->listas)) {
            foreach($request->listas as $lista_id){
                $lista = Lista::find($lista_id);
                $result = $cache->getCached('\Uspdev\Replicado\DB::fetchAll',$lista->replicado_query);
                $emails_lista = array_column($result, 'codema');
                $emails = array_merge($emails,$emails_lista);
                /* Emails adicionais da lista */
                if(!empty($lista->emails_adicionais)){
                    $emails_adicionais = explode(',',$lista->emails_adicionais); 
                    $emails = array_merge($emails,$emails_adicionais);
                 }
            }
            /* Savar coleções usadas na listaDinamica */
            $listaDinamica->listas_ids = implode(',',$request->listas);
        } else {
            $listaDinamica->listas_ids = null;
        }
        
        /* Emails adicionais especificamente nesta lista dinâmica */
        $listaDinamica->emails_adicionais = Utils::trimEmails($request->emails_adicionais);
        if(!empty($listaDinamica->emails_adicionais)) {
            $emails_adicionais = explode(',',$listaDinamica->emails_adicionais); 
            $emails = array_merge($emails,$emails_adicionais);
        }

        /* Agora vamos no mailman  */
        $url = $listaDinamica->url_mailman . '/' . $listaDinamica->name;
        $mailman = new MailmanAPI($url,$listaDinamica->pass,false);

        /* Remove emails atuais dessa lista */
        $emails_mailman = $mailman->getMemberlist();
        $emails_mailman = array_map( 'trim', $emails_mailman );
        $mailman->removeMembers($emails_mailman);
        
        /* Emails allowed não pode fazer parte da lista */
        $emails_allowed = explode(',',$listaDinamica->emails_allowed);
        $emails = array_diff($emails,$emails_allowed);

        /* Adiciona emails no mailman */
        $emails = array_map( 'trim', $emails );
        $emails = array_unique($emails);
        $mailman->addMembers($emails);

        $listaDinamica->last_user_id = Auth::user()->id;
        $listaDinamica->stat_mailman_total = count($emails);
        $listaDinamica->stat_mailman_date = date('Y-m-d H:i:s');
        $listaDinamica->save();

        $request->session()->flash('alert-success', 
            "Lista Dinâmica redefinida com sucesso, totalizando " .
            count($emails) . " e-mails");

        return redirect("/listas_dinamicas/$listaDinamica->id");
    }

    /* Esse método está repetido de ListaController.php
       Criar uma classe auxiliar     
    */
    private function setConfigMailman($lista) {
        if(!empty($lista->pass) && !empty($lista->url_mailman) && !empty($lista->name)) {
            $url = $lista->url_mailman . '/' . $lista->name;
            $mailman = new MailmanAPI($url,$lista->pass,false);
            $mailman->configPrivacySender(explode(',',$lista->emails_allowed));
        }
    }
}
