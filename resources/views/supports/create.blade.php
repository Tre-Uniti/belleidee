@extends('app')
@section('siteTitle')
    Create Question
@stop

@section('centerText')
    @include ('errors.list')

    {!! Form::open(['url' => 'supports']) !!}
    @include ('supports._form', ['submitButtonText' => 'Create Support Request'])
@stop