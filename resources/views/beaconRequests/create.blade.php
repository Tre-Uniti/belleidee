@extends('app')
@section('siteTitle')
    Request Beacon
@stop

@section('centerText')
    @include ('errors.list')

    {!! Form::open(['url' => 'beaconRequests']) !!}
    @include ('beaconRequests._form', ['submitButtonText' => 'Request Beacon'])
@stop