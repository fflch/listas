@extends('master')

@section('content_header')
    <h1>Editar Lista</h1>
@stop


@section('content')

@include('messages.flash')
@include('messages.errors')

<div class="row">


    <div class="col">
        <form method="post" action="{{ action('ListaController@update', $lista->id) }}">
            {{ csrf_field() }}
            {{ method_field('patch') }}
            @include('listas.form')
        </form>
    </div>
</div>

@stop
