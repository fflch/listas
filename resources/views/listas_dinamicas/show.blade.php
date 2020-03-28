@extends('master')

@section('content_header')
  <h1>listaDinamica: {{ $listaDinamica->nome }} </h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

@can('admin')
<div>
    <a href="{{action('ListaDinamicaController@edit', $listaDinamica->id)}}" class="btn btn-success">Editar</a>
</div>
@endcan('admin')

<br>

@if(!empty($listaDinamica->url_mailman))
<div>
    <a href="/redefinir/{{$listaDinamica->id}}" class="btn btn-warning">Redefinir configurações desta lista</a>
</div>
@endif

<br>

<div class="card">
    <div class="card-header">{{ $listaDinamica->description }}</div>
    <ul class="list-group list-group-flush">

        <li class="list-group-item"><b>name</b>: {{ $listaDinamica->name }}</li>
        <li class="list-group-item"><b>url_mailman</b>: {{ $listaDinamica->url_mailman }}</li>
        @can('admin')
        <li class="list-group-item"><b>pass</b>: {{ $listaDinamica->pass }}</li>
        @endcan('admin')
        <li class="list-group-item"><b>emails_allowed</b>: {{ $listaDinamica->emails_allowed }}</li>
        <li class="list-group-item"><b>emails_adicionais</b>: {{ $listaDinamica->emails_adicionais }}</li>
        @if(!empty($listaDinamica->stat_mailman_date))
        <div class="card">
            <div class="card-header">Última redefinição realizada</div>
                <ul class="list-group list-group-flush">

                    <li class="list-group-item"><b>Data</b>: 
                        {{ $listaDinamica->stat_mailman_date }}
                    </li>

                    <li class="list-group-item"><b>Total de Emails</b>: 
                        {{ $listaDinamica->stat_mailman_total }}
                    </li>

                </ul>
            <div>
        </div>
        @endif

    </ul>
</div>

@stop


