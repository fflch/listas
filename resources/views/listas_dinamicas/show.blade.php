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

@if(!empty($listaDinamica->stat_mailman_date))
<div class="card">
    <div class="card-header">Última redefinição realizada</div>
    <div class="card-body">
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><b>Alterado por</b>: 
                @php
                /* Ok, isso tá muito porco, será mudado */
                $tmp = \App\User::find($listaDinamica->last_user_id);
                @endphp
                {{ $tmp->name }}
            </li>
            <li class="list-group-item"><b>Data</b>: 
                {{  Carbon\Carbon::parse($listaDinamica->stat_mailman_date)->format('d/m/Y H:i') }}
            </li>
            <li class="list-group-item"><b>Total de Emails</b>: 
                {{ $listaDinamica->stat_mailman_total }}
            </li>

            <li class="list-group-item"><b>Coleções de emails</b>:
                <ul >
                    @forelse($listas as $lista)
                        <li>{{ $lista->description }}</li>
                    @empty
                        <li>Não há coleções agregadas a esta lista no momento</li>
                    @endforelse
                </ul>
            </li>
            <li class="list-group-item"><b>E-mails adicionais</b>: {{ $listaDinamica->emails_adicionais }}</li>
        </ul>
    <div>
</div> </div></div>
@endif

<br>
<div class="card">
    <div class="card-header">{{ $listaDinamica->description }}</div>
    <div class="card-body">
        <ul class="list-group list-group-flush">

            <li class="list-group-item"><b>name</b>: {{ $listaDinamica->name }}</li>
            <li class="list-group-item"><b>url_mailman</b>: {{ $listaDinamica->url_mailman }}</li>
            @can('admin')
            <li class="list-group-item"><b>pass</b>: {{ $listaDinamica->pass }}</li>
            @endcan('admin')
            <li class="list-group-item"><b>emails com autorização de uso desta lista</b>: {{ $listaDinamica->emails_allowed }}</li>
        </ul>
    </div>
</div>

@stop


