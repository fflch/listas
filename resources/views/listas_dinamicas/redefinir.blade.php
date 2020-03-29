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
                            <label for="emails_adicionais"><b>Escolha as coleções de emails para compor essa lista:</b> </label><br>
                            <small><b>Atenção:</b>
                                Não crie listas com muitos emails (>5000 e-mails), se for necessário, use listas estáticas para grande volumes de e-mails. Cada coleção está acompanhada pela quantidade de e-mails que a compõe. 
                            </small><br><br>

                            @foreach($listas->sortBy('description') as $lista)
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="{{ $lista->id }}" name="listas[]">
                                  <label class="form-check-label" for="listas">
                                    {{ $lista->description }} ( {{ $lista->stat_replicado_updated + 0 }} )
                                  </label>
                                </div>
                            @endforeach()

                            </div>

                            <div class="form-group">
                              <label for="emails_adicionais"><b>Emails adicionais separados por vírgula</b></label>
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
