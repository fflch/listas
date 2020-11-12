@extends('master')

@section('content_header')
    <h1>Cadastrar Consulta</h1>
@stop

@section('content')

@include('messages.flash')
@include('messages.errors')

<div class="row">


        <div class="col">
            <form method="post" action="{{ url('consultas') }}">
                {{ csrf_field() }}
                @include('consultas.form')
            </form>
        </div>
    </div>

@stop
