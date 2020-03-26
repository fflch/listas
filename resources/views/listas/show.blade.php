@extends('master')

@section('content_header')
  <h1>lista: {{ $lista->nome }} </h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

<div>
    <a href="{{action('ListaController@edit', $lista->id)}}" class="btn btn-success">Editar</a>
</div>
<br>

<div class="card">
    <ul class="list-group list-group-flush">

        <li class="list-group-item"><b>name</b>: {{ $lista->name }}</li>
        <li class="list-group-item"><b>url_mailman</b>: {{ $lista->url_mailman }}</li>
        <li class="list-group-item"><b>description</b>: {{ $lista->description }}</li>
        <li class="list-group-item"><b>pass</b>: {{ $lista->pass }}</li>
        <li class="list-group-item"><b>emails_allowed</b>: {{ $lista->emails_allowed }}</li>
        <li class="list-group-item"><b>replicado_query</b>: {{ $lista->replicado_query }}</li>

    </ul>
</div>

@stop


