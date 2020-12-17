@extends('master')

@section('content_header')
    <h1>Email</h1>
@stop

@section('content')

@include('messages.flash')
@include('messages.errors')

<div class="row">

        <div class="col">
            <form method="post" action="/subscriptions">
                {{ csrf_field() }}

                    <div class="card">
                        <div class="card-header">Listas - Inscrições</div>
                        <div class="card-body">

                            <div class="form-group">
                              <label for="email"><b>Email</b></label>
                              <input type="email" id="email" class="form-control" name="email">
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
