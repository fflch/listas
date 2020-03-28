@extends('master')

@section('content_header')
    <h1>Cadastrar nova lista</h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')

@can('admin')
<div>
<a href="{{ route('listas_dinamicas.create') }}" class="btn btn-success">
    Adicionar lista Dinâmica
</a>
</div>
@endcan('admin')
<br>

<div class="card">
    <div class="card-header"><b>Listas Dinâmicas</b></div>
    <div class="card-body">

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th></th>
                @can('admin') <th></th><th></th> @endcan('admin')
            </tr>
        </thead>
        <tbody>
            @foreach($listasDinamicas->sortBy('description') as $listaDinamica)
            <tr>
                <td><a href="/listas_dinamicas/{{ $listaDinamica->id }}">{{ $listaDinamica->description }}</a></td>
                @can('admin')
                <td>
                    <a href="{{action('ListaDinamicaController@edit', $listaDinamica->id)}}" class="btn btn-warning">Editar</a>
                </td>
                <td>
                    <form action="{{action('ListaDinamicaController@destroy', $listaDinamica->id)}}" method="post">
                        {{csrf_field()}}
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="delete-item btn btn-danger" type="submit">Deletar</button>
                    </form>
                </td>
                @endcan('admin')
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
</div>

@stop
