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

@if(!empty($lista->url_mailman))
<div>
    <a href="{{action('ListaController@updateMailman', $lista->id)}}" class="btn btn-warning">Atualizar lista com emails do Replicado</a>
</div>
@endif


<br>

<div class="card">
    <div class="card-header">{{ $lista->description }}</div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><b>replicado_query</b>: {{ $lista->replicado_query }}</li>
    </ul>
</div>

@if(!empty($lista->url_mailman))
<div class="card">
    <div class="card-header">Mailman</div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><b>name</b>: {{ $lista->name }}</li>
        <li class="list-group-item"><b>url_mailman</b>: {{ $lista->url_mailman }}</li>
        <li class="list-group-item"><b>pass</b>: {{ $lista->pass }}</li>
        <li class="list-group-item"><b>emails_allowed</b>: {{ $lista->emails_allowed }}</li>
        <li class="list-group-item"><b>emails_adicionais</b>: {{ $lista->emails_adicionais }}</li>
        @if(!empty($lista->stat_mailman_date))
        <div class="card">
            <div class="card-header">Estatística da Sincronização</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><b>Data</b>: {{ $lista->stat_mailman_date }}</li>
                    <li class="list-group-item"><b>Emails no replicado na momento da sicronização</b>: 
                        {{ $lista->stat_mailman_replicado }}</li>

                    <li class="list-group-item"><b>Emails no replicado agora</b>: 
                        {{ $lista->stat_replicado_updated }}</li>

                    <li class="list-group-item"><b>Email no mailman antes da sincronização</b>: 
                        {{ $lista->stat_mailman_before }}</li>

                    <li class="list-group-item"><b>Email no mailman depois da sincronização</b>: 
                        {{ $lista->stat_mailman_after }}</li>

                    <li class="list-group-item"><b>Emails adicionados no mailman</b>: 
                        {{ $lista->stat_mailman_added }}</li>

                    <li class="list-group-item"><b>Emails removidos do mailman</b>: 
                        {{ $lista->stat_mailman_removed }}</li>

                </ul>
            <div>
        </div>
        @endif

    </ul>
</div>
@endif

@stop


