<?php

use Illuminate\Support\Facades\Route;

/* index */
Route::get('/home', 'IndexController@index')->name('home');
Route::get('/', 'IndexController@index');

/* rotas para login e logout */
Route::get('login', 'Auth\LoginController@redirectToProvider')->name('login');;
Route::get('callback', 'Auth\LoginController@handleProviderCallback');
Route::post('/logout', 'Auth\LoginController@logout');
Route::get('/logout', 'Auth\LoginController@logout');

/* resource listas model */
Route::resource('/listas', 'ListaController');
Route::resource('/listas_dinamicas', 'ListaDinamicaController');

/* TODO: Mudar para POST */
Route::get('/emails', 'EmailController@form');
Route::post('/emails', 'EmailController@show');
Route::get('/emails/{lista}', 'EmailController@emails');

/* TODO: Mudar para POST */
Route::get('/updateMailman/{lista}', 'ListaController@updateMailman');

Route::get('/redefinir/{listaDinamica}', 'ListaDinamicaController@redefinirForm');
Route::post('/redefinir/{listaDinamica}', 'ListaDinamicaController@redefinir');

/* User */
Route::resource('/users', 'UserController');
