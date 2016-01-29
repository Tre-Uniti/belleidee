@extends('app')
@section('siteTitle')
    Settings
@stop

@section('centerText')
    @include ('errors.list')

    {!! Form::open(['url' => 'support']) !!}
    @include ('supports._form', ['submitButtonText' => 'Create Support Request'])
@stop
