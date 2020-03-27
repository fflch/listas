<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\Numeros_USP;
use App\User;
use Uspdev\Replicado\Pessoa;
use Uspdev\Replicado\DB;
use App\Lista;
use Uspdev\Cache\Cache;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:authorized');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('role','authorized')->get();
        return view('users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
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
            'numero_usp' => ['required',new Numeros_USP($request->numero_usp)],
        ]);

        $user = User::where('codpes',$request->numero_usp)->first();
        if (is_null($user)) {
            $user = new User;
        }

        $user->codpes = $request->numero_usp;
        $user->email = Pessoa::email($request->numero_usp);
        $user->name = Pessoa::dump($request->numero_usp)['nompesttd'];
        $user->role = 'authorized';
        $user->save();
        $request->session()->flash('alert-info','Pessoa adicionada com sucesso');
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function emails(Request $request, Lista $lista)
    {
        $cache = new Cache();
        $result = $cache->getCached('\Uspdev\Replicado\DB::fetchAll',$lista->replicado_query);
        $emails = array_column($result, 'codema');

        $request->session()->flash('alert-success', "Emails gerado com sucesso: {$lista->description}");
        $emails = implode(', ',$emails);

        /* Atualiza Estatística */
        $lista->stat_replicado_updated = count($emails);
        $lista->save();

        return view('emails',compact('emails'));
    }
}
