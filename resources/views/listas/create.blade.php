@extends('master')

@section('content_header')
    <h1>Cadastrar Lista</h1>
@stop

@section('content')

<div class="row">
    @include('messages.flash')
    @include('messages.errors')

        <div class="col-md-6">
            <form method="post" action="{{ url('listas') }}">
                {{ csrf_field() }}
                @include('listas.form')
            </form>
        </div>
    </div>

@stop
