@extends('app')
@section('siteTitle')
    Create Belief
@stop

@section('centerText')
    @include ('errors.list')

    {!! Form::open(['url' => 'legacies']) !!}
    @include ('legacies._form', ['submitButtonText' => 'Create Legacy'])
@stop


