@extends('app')
@section('siteTitle')
    Create Draft
@stop

@section('centerText')
    @include ('errors.list')

    {!! Form::open(['url' => 'drafts']) !!}
    @include ('drafts._form', ['submitButtonText' => 'Create Draft'])
@stop

@include('drafts.rightSide')


