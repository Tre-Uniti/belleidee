@extends('app')
@section('siteTitle')
    Create Belief
@stop

@section('centerText')
    @include ('errors.list')

    {!! Form::open(['url' => 'beliefs']) !!}
    @include ('beliefs._form', ['submitButtonText' => 'Create Belief'])
@stop