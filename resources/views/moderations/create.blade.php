@extends('app')
@section('siteTitle')
    Create Moderation
@stop

@section('centerText')
    @include ('errors.list')

    {!! Form::open(['url' => 'moderations']) !!}
    @include ('moderations._form', ['submitButtonText' => 'Create Moderation'])
@stop



