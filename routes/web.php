<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ListaController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubscriptionController;
use App\Mail\Unsubscribe;

/* index */
Route::get('/home', [IndexController::class, 'index'])->name('home');
Route::get('/', [IndexController::class, 'index']);

/* resource listas model */
Route::resource('/listas', ListaController::class);
Route::resource('/consultas', ConsultaController::class);
Route::resource('/users', UserController::class);

/* Gerador de emails */
Route::get('/emails', [EmailController::class, 'form']);
Route::post('/emails', [EmailController::class, 'show']);

/* Mailman */
Route::post('/mailman/{lista}', [ListaController::class, 'mailman']);

/* Subscription */
Route::get('/subscriptions', [SubscriptionController::class, 'create']);
Route::post('/subscriptions', [SubscriptionController::class, 'store']);

Route::get('/unsubscribe', [SubscriptionController::class,'index'])->name('unsubscribe');
Route::post('/unsubscribe_request', [SubscriptionController::class,'unsubscribe'])->name('unsubscribe_request');


# unsubscribe
//Route::post('/unsubscribe/{lista}/{email}', [SubscriptionController::class,'unsubscribe_request']);
Route::post('/unsubscribe/{lista}/{email}', [SubscriptionController::class,'unsubscribe']);
Route::get('/unsubscribe_mail', function(){
    return new Unsubscribe('ricardo_santos@usp.br', 'http://127.0.0.1:8000/subscriptions');
    //Mail::send(new Unsubscribe());
});

# Logs  
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->middleware('can:admin');
