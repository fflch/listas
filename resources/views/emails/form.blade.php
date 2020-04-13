@extends('master')

@section('content_header')
    <h1>Gerar emails a partir de números usp</h1>
@stop

@section('content')

@include('messages.flash')
@include('messages.errors')

<div class="row">

        <div class="col">
            <form method="post" action="/emails">
                {{ csrf_field() }}

                    <div class="card">
                        <div class="card-header">Gerar emails a partir de números usp</div>
                        <div class="card-body">

                            <div class="form-group">
                              <label for="numeros_usp"><b>Números USP (separados por vírgula)</b></label>
                              <textarea id="numeros_usp" class="form-control" name="numeros_usp"></textarea>
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
