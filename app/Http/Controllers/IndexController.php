<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lista;

class IndexController extends Controller
{
    public function index()
    {
        $mailman = Lista::whereNotNull('url_mailman')->get();
        $no_mailman = Lista::whereNull('url_mailman')->get();
        return view('index',compact('no_mailman','mailman'));
    }
}
