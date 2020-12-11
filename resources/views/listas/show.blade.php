@extends('master')


@section('content')
@include('messages.flash')
@include('messages.errors')

<h1>{{ $lista->description }} </h1>


<div>
    <a href="/listas/{{ $lista->id }}/edit" class="btn btn-success">Editar</a>
</div>
<br>
<div>
    <form method="POST" action="/mailman/{{ $lista->id }}">
    @csrf
    <button type="submit" class="btn btn-warning" name="mailman" value="config">Atualizar emails da lista</button>
    <button type="submit" class="btn btn-warning" name="mailman" value="emails">Atualizar emails da lista</button>
    </form>
</div>
<br>
<br>

<div class="card">
    <div class="card-header">Consultas</div>
    <ul class="list-group list-group-flush">
        @foreach($lista->consultas()->get() as $consulta)
            <li class="list-group-item">{{ $consulta->nome }}</li>
        @endforeach
    </ul>
</div>
<br>

<div class="card">
    <div class="card-header">Mailman</div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><b>name</b>: {{ $lista->name }}</li>
        <li class="list-group-item"><b>url_mailman</b>: {{ $lista->url_mailman }}</li>
        <li class="list-group-item"><b>url completa</b>: <a href="{{ $lista->url_mailman }}/{{ $lista->name }}" target="_blank">{{ $lista->url_mailman }}/{{ $lista->name }}</a></li>
        <li class="list-group-item"><b>pass</b>: {{ $lista->pass }}</li>
        <li class="list-group-item"><b>emails_allowed</b>: {{ $lista->emails_allowed }}</li>
        <li class="list-group-item"><b>emails_adicionais</b>: {{ $lista->emails_adicionais }}</li>
    </ul>
</div>

<br>
<div class="card">
    <div class="card-header">Estatística da Sincronização</div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><b>Data</b>: {{ $lista->stat_mailman_date }}</li>
            <li class="list-group-item"><b>Emails no replicado na momento da sicronização</b>:
                {{ $lista->stat_mailman_replicado }}</li>

            <li class="list-group-item"><b>Emails no replicado agora</b>:
                {{ $lista->stat_replicado_updated }}</li>

            <li class="list-group-item"><b>Emails Adicionais</b>:</li>

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


@stop


