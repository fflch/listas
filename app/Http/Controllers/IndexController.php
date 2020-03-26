<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lista;

class IndexController extends Controller
{
    public function index()
    {
        $listas = Lista::all();
        return view('index',compact('listas'));
    }
}
