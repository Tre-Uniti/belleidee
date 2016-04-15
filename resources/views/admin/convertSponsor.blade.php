@extends('app')
@section('siteTitle')
    Convert Sponsor
@stop
@section('centerText')
    @include ('errors.list')
    {!! Form::open(['route' => 'convertSponsor', 'files' => true]) !!}
    @include ('admin._sponsor', ['submitButtonText' => 'Create Sponsor'])
@stop