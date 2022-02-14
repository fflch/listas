@extends('master')

@section('content')

@include('messages.flash')
@include('messages.errors')

<h3>Gerenciamento de Inscrições</h3>
<br>

<p>
Selecione a lista para solicitar sua desinscrição. Para se inscrever novamente, remova seu check (não precisa apagar o motivo da desinscrição).  
<br>
<input  type="checkbox" value="" name="">: Listas inscritas &nbsp;&nbsp;  
<input  type="checkbox" value="" name="" checked> Listas desinscritas. 
</p>

@if(sizeof($listas) > 0 || sizeof($unsubscribed_listas) > 0)
<form method="POST" action="{{$form_action}}">
    @csrf
    <input type="hidden" name="email" value="{{$email}}">
    <table class="table table-light ">
        <thead>
            <tr>
                <th>
                    Desinscrever-se da lista
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
                        <textarea class="form-control" id="motivo{{ $lista->id }}" name="motivo{{ $lista->id }}" rows="2" style="border-color:#5b5b5b;"></textarea>
                    </div>
                </td>
            </tr>
        @endforeach
        @foreach ($unsubscribed_listas as $unsubscribed_lista)
            <tr>
                <td>
                    <input  type="checkbox" value="{{$unsubscribed_lista->id }}" name="id_lista[]" id="idLista{{$unsubscribed_lista->id }}" checked>   
                    <label for="idLista{{$unsubscribed_lista->id }}">{{$unsubscribed_lista->description }} - {{$unsubscribed_lista->name}}</label></td>
                <td>
                    <div class="form-group">
                        <textarea class="form-control" id="motivo{{$unsubscribed_lista->id }}" name="motivo{{$unsubscribed_lista->id }}"  rows="2" style="border-color:#5b5b5b;">{{$unsubscribed_lista->motivo }}</textarea>
                    </div>
                </td>
            </tr>
        @endforeach
        
    </table>
    <br>
    <button type="submit" class="btn btn-success mb-2">Salvar alterações </button>
</form>
@else
    <p>
        O email {{$email}} não consta em nenhuma lista.
    </p>
@endif
@endsection

