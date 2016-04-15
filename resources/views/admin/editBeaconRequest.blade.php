@extends('app')
@section('siteTitle')
    Edit Beacon Request
@stop
@section('centerText')
    @include ('errors.list')
    {!! Form::model($beaconRequest, ['route' => ['updateBeaconRequest', $beaconRequest->id], 'method' => 'patch']) !!}
    @include ('admin._beaconEdit', ['submitButtonText' => 'Update Request'])
@stop