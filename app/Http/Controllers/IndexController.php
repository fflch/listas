<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lista;
use App\ListaDinamica;

class IndexController extends Controller
{
    public function index()
    {
        $mailman = Lista::whereNotNull('url_mailman')->get();
        $no_mailman = Lista::whereNull('url_mailman')->get();
        $listas_dinamicas = ListaDinamica::all();
        return view('index',compact('no_mailman','mailman','listas_dinamicas'));
    }
}
