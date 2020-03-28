@extends('master')

@section('content_header')
    <h1>Cadastrar Lista</h1>
@stop

@section('content')

@include('messages.flash')
@include('messages.errors')

<div class="row">


        <div class="col">
            <form method="post" action="{{ url('listas') }}">
                {{ csrf_field() }}
                @include('listas.form')
            </form>
        </div>
    </div>

@stop
