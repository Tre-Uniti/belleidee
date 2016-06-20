@extends('app')
@section('siteTitle')
    Create Promotion
@stop

@section('centerText')
    @include ('errors.list')

    {!! Form::open(['url' => 'promotions']) !!}
    @include ('promotions._form', ['submitButtonText' => 'Create Promotion'])
@stop