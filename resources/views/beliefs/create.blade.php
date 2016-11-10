@extends('app')
@section('siteTitle')
    Create Belief
@stop

@section('centerText')
    @include ('errors.list')

    {!! Form::open(['url' => 'beliefs', 'files' => true]) !!}
    @include ('beliefs._form', ['submitButtonText' => 'Create Belief'])
@stop


