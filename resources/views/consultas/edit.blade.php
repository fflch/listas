@extends('master')

@section('content_header')
    <h1>Editar Consulta</h1>
@stop


@section('content')

@include('messages.flash')
@include('messages.errors')

<div class="row">


    <div class="col">
        <form method="post" action="{{ action('\App\Http\Controllers\ConsultaController@update', $consulta->id) }}">
            {{ csrf_field() }}
            {{ method_field('patch') }}
            @include('consultas.form')
        </form>
    </div>
</div>

@stop
