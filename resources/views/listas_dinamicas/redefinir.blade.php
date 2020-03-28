@extends('master')

@section('content_header')
    <h1>Redefinir Lista Dinâmica</h1>
@stop

@section('content')

@include('messages.flash')
@include('messages.errors')

<div class="row">

        <div class="col">
            <form method="post" action="/redefinir/{{ $listaDinamica->id }}">
                {{ csrf_field() }}

                    <div class="card">
                        <div class="card-header">Redefinição da lista dinâmica</div>
                        <div class="card-body">

                            <div class="form-group">
                            <label for="emails_adicionais">Escolha as coleções de emails para compor essa lista: </label>

                            @foreach($listas->sortBy('description') as $lista)
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="{{ $lista->id }}" name="listas[]">
                                  <label class="form-check-label" for="listas">
                                    {{ $lista->description }}
                                  </label>
                                </div>
                            @endforeach()

                            </div>

                            <div class="form-group">
                              <label for="emails_adicionais">Emails adicionais separados por vírgula</label>
                              <textarea id="emails_adicionais" class="form-control" name="emails_adicionais">{{ $listaDinamica->emails_adicionais ?? old('emails_adicionais')  }}</textarea>
                            </div>

                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Enviar">
                    </div>
            </form>
        </div>
    </div>

@stop
