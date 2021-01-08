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
                        <th>Coleções</th>
                        <th>Autorizados</th>
      @can('authorized')<th>Emails adicionais</th>@endcan('authorized')
                    </tr>
                </thead>
                <tbody>
                    @foreach($listas->sortBy('description') as $lista)
                    <tr>
                        <td>
                            @auth
                                <a href="/listas/{{ $lista->id }}">{{ $lista->description }}</a>
                            @else
                                {{ $lista->description }}
                            @endauth
                        </td>

                        <td>
                            {{ $lista->name }}{{ config('listas.mailman_domain') }} <br>
                            {{ $lista->stat_mailman_after > 0 ? 'Total de emails: ' . $lista->stat_mailman_after:'' }}
                        </td>
                        <td>
                            <ul>
                                @forelse($lista->consultas as $consulta)
                                    @auth
                                        <li><a href="/consultas/{{ $consulta->id }}">{{ $consulta->nome }}</a></li>
                                    @else
                                        <li>{{ $consulta->nome }}</li>
                                    @endauth
                                @empty
                                    <li>Não há coleções</li>
                                @endforelse
                            </ul>
                        </td>
                        
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
                        <td>
                            @can('admin')
                                <a href="/consultas/{{ $consulta->id }}">{{ $consulta->nome }}</a>
                            @else
                                {{ $consulta->nome }}
                            @endcan('admin')
                        </td>

                        <td>
                            <ul>
                                @forelse($consulta->listas as $lista)
                                    @auth
                                        <li><a href="/listas/{{ $lista->id }}">{{ $lista->name }}</a></li>
                                    @else
                                        <li>{{ $lista->name }}</li>
                                    @endauth
                                @empty
                                    <li>Não está associada à nenhuma lista</li>
                                @endforelse
                            </ul>
                        </td>
                    </tr>
                    
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

