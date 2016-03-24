@extends('app')
@section('siteTitle')
    Request Sponsor
@stop

@section('centerText')
    @include ('errors.list')

    {!! Form::open(['url' => 'sponsorRequests']) !!}
    @include ('sponsorRequests._form', ['submitButtonText' => 'Request Sponsor'])
@stop