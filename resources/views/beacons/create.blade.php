@extends('app')
@section('siteTitle')
    Create Beacon
@stop

@section('centerText')
    @include ('errors.list')

    {!! Form::open(['url' => 'beacons', 'files' => true]) !!}
    @include ('beacons._form', ['submitButtonText' => 'Request Beacon'])
@stop


