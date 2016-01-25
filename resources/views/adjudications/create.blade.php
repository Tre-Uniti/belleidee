@extends('app')
@section('siteTitle')
    Create Moderation
@stop

@section('centerText')
    @include ('errors.list')

    {!! Form::open(['url' => 'adjudications']) !!}
    @include ('adjudications._form', ['submitButtonText' => 'Create Adjudication'])
@stop



