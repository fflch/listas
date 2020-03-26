@extends('master')

@section('content')

@include('messages.flash')
@include('messages.errors')

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nome da Lista</th>
                <th>Lista</th>
                <th>E-mails Permitidos</th>
@can('authorized') <th>Gerar lista com emails</th> @endcan('authorized')
            </tr>
        </thead>
        <tbody>
            @foreach($mailman->sortBy('name') as $lista)
            <tr>
                <td>{{ $lista->description }}</td>
                <td>{{ $lista->name }}@listas.usp.br</td>   
                <td>{{ $lista->emails_allowed }}</td>     
@can('authorized')
<td><a href="/emails/{{$lista->id}}" class="btn btn-primary">Gerar</a></td>
@endcan('authorized')
     
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@can('authorized')
    <h3>Coleções de emails que não possuem listas:</h3>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nome da Coleção</th>
                    <th>Gerar lista com emails</th>
                </tr>
            </thead>
            <tbody>
                @foreach($no_mailman->sortBy('name') as $lista)
                <tr>
                    <td>{{ $lista->description }}</td>
                    <td><a href="/emails/{{$lista->id}}" class="btn btn-primary">Gerar</a></td>         
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endcan('authorized')
@endsection

