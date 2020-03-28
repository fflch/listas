@extends('master')

@section('content_header')
    <h1>Editar Lista Dinâmica</h1>
@stop


@section('content')

@include('messages.flash')
@include('messages.errors')

<div class="row">

    <div class="col">
        <form method="post" action="{{ action('ListaDinamicaController@update', $listaDinamica->id) }}">
            {{ csrf_field() }}
            {{ method_field('patch') }}
            @include('listas_dinamicas.form')
        </form>
    </div>
</div>

@stop
