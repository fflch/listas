@extends('master')

@section('content')

@include('messages.flash')
@include('messages.errors')

<div class="card">
    <div class="card-header">Listas</div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nome da Lista</th>
                        <th>Lista</th>
                        <th>emails</th>
                        <th>Autorizados</th>
        @can('authorized') <th>Gerar lista com emails</th> @endcan('authorized')
                    </tr>
                </thead>
                <tbody>
                    @foreach($mailman->sortBy('description') as $lista)
                    <tr>
                        <td>{{ $lista->description }}</td>
                        <td>{{ $lista->name }}@listas.usp.br</td>
                        <td>{{ $lista->stat_replicado_updated }}</td>
                        <td>
                            @if ($lista->emails_allowed != "")
                              <ul>
                              @foreach(explode(',', $lista->emails_allowed) as $email)
                                <li>{{$email}}</li>
                              @endforeach
                              </ul>
                            @endif
                        </td>
        @can('authorized')
        <td><a href="/emails/{{$lista->id}}" class="btn btn-primary">Gerar</a></td>
        @endcan('authorized')

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<br><br>
@can('authorized')

<div class="card">
    <div class="card-header">Coleções de emails que não possuem listas</div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nome da Coleção</th>
                        <th>Emails</th>
                        <th>Gerar lista com emails</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($no_mailman->sortBy('description') as $lista)
                    <tr>
                        <td>{{ $lista->description }}</td>
                        <td>{{ $lista->stat_replicado_updated }}</td>
                        <td><a href="/emails/{{$lista->id}}" class="btn btn-primary">Gerar</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endcan('authorized')
@endsection

