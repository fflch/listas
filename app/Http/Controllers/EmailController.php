<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Uspdev\Replicado\DB;
use Uspdev\Cache\Cache;
use App\Models\Lista;


class EmailController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:authorized');
    }

    public function emails(Request $request, Lista $lista)
    {
        $this->authorize('authorized');
        $cache = new Cache();
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetchAll',$lista->replicado_query);
        $emails = array_column($result, 'codema');

        /* Atualiza Estatística */
        $lista->stat_replicado_updated = count($emails);
        $lista->save();

        $emails = implode(', ',$emails);
        $request->session()->flash('alert-success', "Emails gerado com sucesso: {$lista->description}");

        return view('emails/emails',compact('emails'));
    }

    public function form(Request $request)
    {
        $this->authorize('authorized');
        return view('emails/form');
    }

    public function show(Request $request)
    {
        $this->authorize('authorized');
        $cache = new Cache();

        $request->validate([
            'numeros_usp' => 'required'
        ]);
        $numeros_usp = array_map('trim', explode(',', $request->numeros_usp));
        $emails = [];
        $not_found = [];

        foreach($numeros_usp as $codpes) {
            $codpes_int = (int) $codpes;
            $query = "SELECT DISTINCT codema FROM LOCALIZAPESSOA WHERE codpes={$codpes_int}";
            $result = $cache->getCached('\Uspdev\Replicado\DB::fetchAll',$query);
            if(empty($result)) array_push($not_found, $codpes);
            else {
                $to_merge = array_column($result, 'codema');
                $emails = array_merge($emails,$to_merge);
            }
        }
        $emails = array_unique($emails);
        $not_found = array_unique($not_found);
        $emails = implode(',',$emails);
        $not_found = implode(',',$not_found);

        if(!empty($not_found)){
            $request->session()->flash('alert-danger', "Emails não encontrados para: {$not_found}");
        }
        $request->session()->flash('alert-success', "Emails gerado com sucesso:");

        return view('emails/emails',compact('emails'));

    }
}
