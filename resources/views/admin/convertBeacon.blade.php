@extends('app')
@section('siteTitle')
    Convert Beacon
@stop
@section('centerText')
    @include ('errors.list')
    {!! Form::open(['route' => 'convertBeacon', 'files' => true]) !!}
    @include ('admin._beacon', ['submitButtonText' => 'Create Beacon'])
@stop