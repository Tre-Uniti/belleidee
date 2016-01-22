@extends('app')
@section('siteTitle')
    Create Intolerance
@stop

@section('centerText')
    @include ('errors.list')

    {!! Form::open(['url' => 'intolerances']) !!}
    @include ('intolerances._form', ['submitButtonText' => 'Create Intolerance'])
@stop



