@extends('app')
@section('siteTitle')
    Create Question
@stop

@section('centerText')
    @include ('errors.list')

    {!! Form::open(['url' => 'supports']) !!}
    @include ('support._form', ['submitButtonText' => 'Create Support Request'])
@stop