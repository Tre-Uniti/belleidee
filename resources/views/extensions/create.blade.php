@extends('app')
@section('siteTitle')
    Create Extension
@stop

@section('centerText')
    @include ('errors.list')
    {!! Form::open(['url' => 'extensions']) !!}
    @include ('extensions._form', ['submitButtonText' => 'Post Extension'])
@stop




