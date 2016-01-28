@extends('app')
@section('siteTitle')
    Settings
@stop

@section('centerText')
    @include ('errors.list')

    {!! Form::open(['url' => 'support']) !!}
    @include ('support._form', ['submitButtonText' => 'Create Support Request'])
@stop
