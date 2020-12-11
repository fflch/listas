@extends('master')

@section('content_header')
  <h1>Nome da Consulta: {{ $consulta->nome }} </h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

    <div>
        <a href="{{action('\App\Http\Controllers\ConsultaController@edit', $consulta->id)}}" class="btn btn-success">Editar</a>
    </div>

    <br>

    <div class="card">
        <div class="card-header">{{ $consulta->nome }}</div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><b>Consulta (Query)</b>: {{ $consulta->replicado_query }}</li>
        </ul>
    </div>
<br>
    <div class="card">
        <div class="card-header">Emails: {{ count($emails) }}</div>
        <div class="card-body">
            {{ implode(', ',$emails) }}
        </div>
    </div>
@stop


