@extends('master')

@section('content_header')
    <h1>Editar Lista</h1>
@stop


@section('content')

<div class="row">
    @include('messages.flash')
    @include('messages.errors')

    <div class="col-md-6">
        <form method="post" action="{{ action('ListaController@update', $lista->id) }}">
            {{ csrf_field() }}
            {{ method_field('patch') }}
            @include('listas.form')
        </form>
    </div>
</div>

@stop
