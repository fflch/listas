@extends('master')

@section('content')

@include('messages.flash')
@include('messages.errors')

{{$emails}}

@endsection

