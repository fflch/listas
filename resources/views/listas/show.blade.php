@extends('master')


@section('content')
@include('messages.flash')
@include('messages.errors')

<h1>{{ $lista->description }} </h1>

@can('admin')
    <div>
        <a href="/listas/{{ $lista->id }}/edit" class="btn btn-success">Editar</a>
    </div>
    <br>
    <div>
        <form method="POST" action="/mailman/{{ $lista->id }}">
        @csrf
        <button type="submit" class="btn btn-warning" name="mailman" value="config">Atualizar configuração da lista</button>
        <button type="submit" class="btn btn-warning" name="mailman" value="emails">Atualizar emails da lista</button>
        </form>
    </div>
@endcan('admin')
<br>
<br>

<div class="row">
<div class="col-sm">
        @include('listas.partials.emails_titles')
    </div>
    
    <div class="col-sm">
        @include('listas.partials.fields')
    </div>


</div>



@stop


