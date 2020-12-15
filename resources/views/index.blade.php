@extends('master')

@section('content')

@include('messages.flash')
@include('messages.errors')

<div class="card">
    <div class="card-header"><b>Listas</b></div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nome da Lista</th>
                        <th>Lista</th>
                        <th>Autorizados</th>
      @can('authorized')<th>Emails adicionais</th>@endcan('authorized')
                    </tr>
                </thead>
                <tbody>
                    @foreach($listas->sortBy('description') as $lista)
                    <tr>
                        @auth
                        <td><a href="/listas/{{ $lista->id }}">{{ $lista->description }}</a></td>
                        @else
                        <td>{{ $lista->description }}</td>
                        @endauth
                        <td>{{ $lista->name }}{{ config('listas.mailman_domain') }}</td>
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
<br>

<div class="card">
    <div class="card-header"><b>Coleções de emails </b></div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-striped">
                <tbody>
                    @foreach($consultas->sortBy('nome') as $consulta)
                    <tr>
                        @can('admin')
                        <td><a href="/consultas/{{ $consulta->id }}">{{ $consulta->nome }}</a></td>
                        @else
                        <td>{{ $consulta->nome }}</td>
                        @endcan('admin')
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

