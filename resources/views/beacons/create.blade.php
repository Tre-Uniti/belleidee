@extends('app')
@section('siteTitle')
    Create Post
@stop

@include('beacons.leftSide')

@section('centerText')
    @include ('errors.list')

    {!! Form::open(['url' => 'beacons']) !!}
    @include ('beacons._form', ['submitButtonText' => 'Request Beacon'])
@stop



@include('beacons.rightSide')


