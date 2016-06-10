@extends('app')
@section('siteTitle')
    Create Draft
@stop

@section('centerText')
    @include ('errors.list')

    {!! Form::open(['url' => 'drafts', 'files' => true]) !!}
    @include ('drafts._form', ['submitButtonText' => 'Create Draft'])
@stop


