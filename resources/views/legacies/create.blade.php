@extends('app')
@section('siteTitle')
    Create Belief
@stop

@section('centerText')
    <h2>Create Legacy</h2>
    @include ('errors.list')

    {!! Form::open(['url' => 'legacies']) !!}
    @include ('legacies._form', ['submitButtonText' => 'Create Legacy'])
@stop


