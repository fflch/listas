@extends('master')

@section('content_header')
    <h1>Cadastrar Lista Dinâmica</h1>
@stop

@section('content')

@include('messages.flash')
@include('messages.errors')

<div class="row">

        <div class="col">
            <form method="post" action="{{ url('listas_dinamicas') }}">
                {{ csrf_field() }}
                @include('listas_dinamicas.form')
            </form>
        </div>
    </div>

@stop
