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
            </tr>
        </thead>
        <tbody>
            @foreach($listas as $lista)
            <tr>
                <td>{{ $lista->description }}</td>
                <td>{{ $lista->name }}@listas.usp.br</td>   
                <td>{{ $lista->emails_allowed }}</td>          
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

