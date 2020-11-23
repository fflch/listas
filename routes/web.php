<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ListaController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\UserController;



/* index */
Route::get('/home', [IndexController::class, 'index'])->name('home');
Route::get('/', [IndexController::class, 'index']);

/* rotas para login e logout */
Route::get('login', [LoginController::class, 'redirectToProvider'])->name('login');;
Route::get('callback', [LoginController::class, 'handleProviderCallback']);
Route::post('/logout', [LoginController::class, 'logout']);
Route::get('/logout', [LoginController::class, 'logout']);

/* resource listas model */
Route::resource('/listas', ListaController::class);
Route::resource('/consultas', ConsultaController::class);

/* TODO: Mudar para POST */
Route::get('/emails', [EmailController::class, 'form']);
Route::post('/emails', [EmailController::class, 'show']);
Route::get('/emails/{lista}', [EmailController::class, 'emails']);

/* TODO: Mudar para POST */
Route::get('/updateMailman/{lista}', [ListaController::class, 'updateMailman']);

/* User */
Route::resource('/users', UserController::class);
