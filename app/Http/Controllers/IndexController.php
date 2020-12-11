<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lista;
use App\Models\Consulta;

class IndexController extends Controller
{
    public function index()
    {
        return view('index',[
            'listas' => Lista::all(),
            'consultas' => Consulta::all()
        ]);
    }
}
