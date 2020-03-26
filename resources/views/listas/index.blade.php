@extends('master')

@section('content_header')
    <h1>Cadastrar nova lista</h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')
<div>
<a href="{{ route('listas.create') }}" class="btn btn-success">
    Adicionar lista
</a>
</div>
<br>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Título da lista</th>
                <th>Mailman?</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($listas->sortBy('name') as $lista)
            <tr>
                <td><a href="/listas/{{ $lista->id }}">{{ $lista->description }}</a></td>
                <td>
                    @if(empty($lista->url_mailman))
                        não
                    @else
                        sim
                    @endif
                </td>
                <td>
                    <a href="{{action('ListaController@edit', $lista->id)}}" class="btn btn-warning">Editar</a>
                </td>
                <td>
                    <form action="{{action('ListaController@destroy', $lista->id)}}" method="post">
                        {{csrf_field()}}
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="delete-item btn btn-danger" type="submit">Deletar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@stop
