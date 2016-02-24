@extends('app')
@section('siteTitle')
    Create Sponsor
@stop

@section('centerText')
    @include ('errors.list')

    {!! Form::open(['url' => 'sponsors', 'files' => true]) !!}
    @include ('sponsors._form', ['submitButtonText' => 'Create Sponsor'])
@stop



