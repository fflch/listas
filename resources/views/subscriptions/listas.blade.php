@extends('master')

@section('content')

@include('messages.flash')
@include('messages.errors')

<h3>Listas encontradas:</h3>
<br>

@if(sizeof($listas) > 0)
<form method="POST" action="{{$form_action}}">
    @csrf
    <input type="hidden" name="email" value="{{$email}}">
    <table class="table table-light w-auto">
        <thead>
            <tr>
                <th>
                    Nome da lista
                </th>
                <th>
                    Motivo da desinscrição
                </th>
            </tr>
        </thead>
        @foreach ($listas as $lista)
            <tr>
                <td>
                    <input  type="checkbox" value="{{ $lista->id }}" name="id_lista[]" id="idLista{{ $lista->id }}">   
                    <label for="idLista{{ $lista->id }}">{{ $lista->description }} - {{$lista->name}}</label></td>
                <td>
                    <div class="form-group">
                        <textarea class="form-control" id="motivo{{ $lista->id }}" name="motivo{{ $lista->id }}" rows="2"></textarea>
                    </div>
                </td>
            </tr>
        @endforeach
    </table>
    <br>
    <button type="submit" class="btn btn-danger mb-2">Solicitar desinscrição das listas selecionadas </button>
</form>
@else
    <p>
        O email {{$email}} não consta em nenhuma lista.
    </p>
@endif
@endsection

