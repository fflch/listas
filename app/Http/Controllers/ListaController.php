<?php

namespace App\Http\Controllers;

use App\Lista;
use Illuminate\Http\Request;
use splattner\mailmanapi\MailmanAPI;
use Uspdev\Replicado\DB;
use Uspdev\Cache\Cache;
use App\Rules\MultipleEmailRule;
use App\Utils;

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
            'emails_allowed' => [new MultipleEmailRule],
            'emails_adicionais' => [new MultipleEmailRule],
        ]);

        $lista = new Lista;
        $lista->name = $request->name;
        $lista->url_mailman = $request->url_mailman;
        $lista->description = $request->description;
        $lista->pass = $request->pass;
        $lista->emails_allowed = Utils::trimEmails($request->emails_allowed);
        $lista->emails_adicionais = Utils::trimEmails($request->emails_adicionais);
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
            'emails_allowed' => [new MultipleEmailRule],
            'emails_adicionais' => [new MultipleEmailRule],
        ]);

        $lista->name = $request->name;
        $lista->url_mailman = $request->url_mailman;
        $lista->description = $request->description;
        $lista->pass = $request->pass;
        $lista->emails_allowed = Utils::trimEmails($request->emails_allowed);
        $lista->emails_adicionais = Utils::trimEmails($request->emails_adicionais);
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
        $cache = new Cache();
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetchAll',$lista->replicado_query);
        $emails_replicado = array_column($result, 'codema');

        /* Emails adicionais */
        if(empty($lista->emails_adicionais)) {
            $emails_adicionais = [];
        }
        else {
            $emails_adicionais = explode(',',$lista->emails_adicionais);
        }
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
        $lista->stat_mailman_before = count($emails_mailman);
        $lista->stat_mailman_after = count($emails_mailman)+count($to_add)-count($to_remove);
        $lista->stat_mailman_added = count($to_add);
        $lista->stat_mailman_removed = count($to_remove);
        $lista->stat_mailman_replicado = count($emails_replicado);
        $lista->stat_replicado_updated = count($emails_replicado);
        $lista->stat_mailman_date = date('Y-m-d H:i:s');
        $lista->save();

        $request->session()->flash('alert-success', 
            count($to_remove) . " emails removidos e " .
            count($to_add) . " adicionados.");

        return redirect("/listas/$lista->id");
    }

}
