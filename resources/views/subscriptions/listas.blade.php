@extends('master')

@section('content')

@include('messages.flash')
@include('messages.errors')

<h3>Listas encontradas:</h3>
<br>
<ul>
@forelse ($listas as $lista)
    <li>{{ $lista->name }} - {{ $lista->description }} -
        <form method="POST" action="/unsubscribe/{{ $lista->id }}/{{ $email }}" class="form-inline">
            @csrf
            <button type="submit" class="btn btn-danger mb-2">Solicitar remoção desta lista </button>
        </form>
    </li>
       
@empty
    <li>Esse email não consta em nenhuma lista</li>
@endforelse
</ul>

@endsection

