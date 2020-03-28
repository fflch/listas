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
        $listaDinamica->emails_adicionais = Utils::trimEmails($request->emails_adicionais);
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
        $listas = Lista::all();
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
        $listaDinamica->emails_adicionais = Utils::trimEmails($request->emails_adicionais);
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

        // Parei aqui
        
        dd($request->listas); //listas_ids

        //$last_user_id = Auth::user();

        $url = $listaDinamica->url_mailman . '/' . $listaDinamica->name;
        $mailman = new MailmanAPI($url,$listaDinamica->pass,false);

        /* Emails da lista */
        $emails_mailman = $mailman->getMemberlist();

        /* Emails do replicado */
        $cache = new Cache();
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetchAll',$listaDinamica->replicado_query);
        $emails_replicado = array_column($result, 'codema');

        /* Emails adicionais */
        if(empty($listaDinamica->emails_adicionais))
            $emails_adicionais = [];
        else
            $emails_adicionais = explode(',',$listaDinamica->emails_adicionais); 
        $emails_updated = array_merge($emails_replicado,$emails_adicionais);
        
        /* Emails que estão no replicado+adicionais, mas não na lista
         * Serão inseridos na lista         
         */
        $to_add = array_diff($emails_updated,$emails_mailman);

        /* Emails que estão na lista, mas não no replicado+adicionais
         * Serão removidos na lista
         */
        $to_remove = array_diff($emails_mailman,$emails_updated);

        $mailman->removeMembers($to_remove);
        $mailman->addMembers($to_add);

        /* update stats */
        $listaDinamica->stat_mailman_before = count($emails_mailman);
        $listaDinamica->stat_mailman_after = count($emails_mailman)+count($to_add)-count($to_remove);
        $listaDinamica->stat_mailman_added = count($to_add);
        $listaDinamica->stat_mailman_removed = count($to_remove);
        $listaDinamica->stat_mailman_replicado = count($emails_replicado);
        $listaDinamica->stat_replicado_updated = count($emails_replicado);
        $listaDinamica->stat_mailman_date = date('Y-m-d H:i:s');
        $listaDinamica->save();

        $request->session()->flash('alert-success', 
            count($to_remove) . " emails removidos e " .
            count($to_add) . " adicionados.");

        return redirect("/listas/$listaDinamica->id");
    }
}
