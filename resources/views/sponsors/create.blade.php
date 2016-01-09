@extends('app')
@section('siteTitle')
    Create Sponsor
@stop

@section('centerText')
    @include ('errors.list')

    {!! Form::open(['url' => 'sponsors']) !!}
    @include ('sponsors._form', ['submitButtonText' => 'Create Sponsor'])
@stop

@include('sponsors.rightSide')


