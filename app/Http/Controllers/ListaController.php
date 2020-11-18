<?php

namespace App\Http\Controllers;

use App\Models\Lista;
use Illuminate\Http\Request;
use splattner\mailmanapi\MailmanAPI;
use Uspdev\Replicado\DB;
use Uspdev\Cache\Cache;
use App\Rules\MultipleEmailRule;
use App\Models\Utils;

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
        $this->setConfigMailman($lista);
        $lista->save();

        //Salva as consultas relacionadas à lista
        $lista->saveConsultasLista($request->replicado_query);

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
        $this->setConfigMailman($lista);
        $lista->save();

        //Salva as consultas relacionadas à lista
        $lista->saveConsultasLista($request->replicado_query);
        
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
        /*
        $lista->consultas()->detach();
        $lista->delete();
        return redirect('/listas');
        */
        die("Not implemented");
    }

    public function updateMailman(Request $request, Lista $lista)
    {
        if(empty($lista->url_mailman)){
            $request->session()->flash('alert-danger', "Mailman não configurado nessa lista");

            return redirect("/listas/$lista->id");
        }

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

        /* Agora vamos no mailman */
        $url = $lista->url_mailman . '/' . $lista->name;
        $mailman = new MailmanAPI($url,$lista->pass,false);

        /* Emails da lista */
        $emails_mailman = $mailman->getMemberlist();

        /* Emails que estão no replicado+adicionais, mas não na lista
         * Serão inseridos na lista
         */
        $to_add = array_diff($emails_updated,$emails_mailman);

        /* Emails allowed não podem fazer parte das listas */
        $emails_allowed = explode(',',$lista->emails_allowed);
        $to_add = array_diff($to_add,$emails_allowed);

        /* Emails que estão na lista, mas não no replicado+adicionais
         * Serão removidos na lista
         */
        $to_remove = array_diff($emails_mailman,$emails_updated);

        /* remove olders */
        $to_remove = array_map( 'trim', $to_remove );
        $mailman->removeMembers($to_remove);

        /* add news */
        $to_add = array_map( 'trim', $to_add );
        $to_add = array_unique($to_add);
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

    private function setConfigMailman($lista) {
        if(!empty($lista->pass) && !empty($lista->url_mailman) && !empty($lista->name)) {
            $owner = 'fflchsti@usp.br';
            $url = $lista->url_mailman . '/' . $lista->name;
            $mailman = new MailmanAPI($url,$lista->pass,false);
            $mailman->configPrivacySender(explode(',',$lista->emails_allowed));
            $mailman->configGeneral($lista->name,$owner,$lista->name);

            /* Os métodos abaixo estão funcionando, porém, são muitas
               requisições. Quando o apache2 do mailman nos bloqueia
               é retornado null.

            $mailman->configGeneral($lista->name,$owner,ucfirst($lista->name));
            $mailman->configPrivacySubscribing();
            $mailman->configPrivacyRecipient();
            $mailman->configDigest();
            $mailman->configNonDigest();
            $mailman->configBounce();
            */            
           
        }
    }

}
