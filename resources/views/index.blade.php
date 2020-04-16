@extends('master')

@section('content')

@include('messages.flash')
@include('messages.errors')

<div class="card">
    <div class="card-header"><b>Listas Consolidadas</b></div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nome da Lista</th>
                        <th>Lista</th>
                        <th>Qtde</th>
                        <th>Autorizados</th>
      @can('authorized')<th>Emails adicionais</th>@endcan('authorized')
                    </tr>
                </thead>
                <tbody>
                    @foreach($mailman->sortBy('description') as $lista)
                    <tr>
                        @can('admin')
                        <td><a href="/listas/{{ $lista->id }}">{{ $lista->description }}</a></td>
                        @else
                        <td>{{ $lista->description }}</td>
                        @endcan('admin')

                        <td>{{ $lista->name }}@listas.usp.br</td>
                        <td>{{ $lista->stat_replicado_updated + 0}}
                            <br>
        @can('authorized')
        <a href="/emails/{{$lista->id}}" class="btn btn-primary">Gerar Emails</a>
        @endcan('authorized')

                        </td>
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
                        <td>
                            @if ($lista->emails_adicionais != "")
                              <ul>
                              @foreach(explode(',', $lista->emails_adicionais) as $email)
                                <li>{{$email}}</li>
                              @endforeach
                              </ul>
                            @endif
                        </td>
                        @endcan('authorized')
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
<br><br>

<div class="card">
    <div class="card-header"><b>Coleções de emails (que não possuem listas consolidadas) </b></div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nome da Coleção</th>
                        <th>Qtde</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($no_mailman->sortBy('description') as $lista)
                    <tr>
                        @can('admin')
                        <td><a href="/listas/{{ $lista->id }}">{{ $lista->description }}</a></td>
                        @else
                        <td>{{ $lista->description }}</td>
                        @endcan('admin')
                        <td>{{ $lista->stat_replicado_updated + 0 }} <br>
                        @can('authorized')<td><a href="/emails/{{$lista->id}}" class="btn btn-primary">Gerar</a>@endcan('authorized')
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

