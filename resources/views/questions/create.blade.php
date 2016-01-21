@extends('app')
@section('siteTitle')
    Create Question
@stop

@section('centerText')
    @include ('errors.list')

    {!! Form::open(['url' => 'questions']) !!}
    @include ('questions._form', ['submitButtonText' => 'Create Question'])
@stop


