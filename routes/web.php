<?php

use Illuminate\Support\Facades\Route;

/* index */
Route::get('/', 'IndexController@index')->name('home');

/* rotas para login e logout */
Route::get('login', 'Auth\LoginController@redirectToProvider');
Route::get('callback', 'Auth\LoginController@handleProviderCallback');
Route::post('/logout', 'Auth\LoginController@logout');
Route::get('/logout', 'Auth\LoginController@logout');

/* resource listas model */
Route::resource('/listas', 'ListaController');
