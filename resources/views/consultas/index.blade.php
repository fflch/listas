@extends('master')

@section('content_header')
    <h1>Cadastrar Nova Consulta</h1>
@stop

@section('content')
    @include('messages.flash')
    @include('messages.errors')
<div>
<a href="{{ route('consultas.create') }}" class="btn btn-success">
    Adicionar Consulta
</a>
</div>
<br>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Título da Consulta</th>
                <th>Consulta (Query)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($consultas->sortBy('nome') as $consulta)
            <tr>
                <td><a href="/consultas/{{ $consulta->id }}">{{ $consulta->nome }}</a></td>
                <td>
                    {{$consulta->replicado_query}}
                </td>
                <td>
                    <a href="{{action('\App\Http\Controllers\ConsultaController@edit', $consulta->id)}}" class="btn btn-warning">Editar</a>
                </td>
                <td>
                    <form action="{{action('\App\Http\Controllers\ConsultaController@destroy', $consulta->id)}}" method="post">
                        {{csrf_field()}}
                        <input name="_method" type="hidden" value="DELETE" >
                        <button class="delete-item btn btn-danger" type="submit" onclick="return confirm('Você tem certeza que deseja apagar?')">Deletar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@stop
