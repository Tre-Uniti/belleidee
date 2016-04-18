@extends('app')
@section('siteTitle')
    Edit Sponsor Request
@stop

@section('centerText')
    <div class = "errors">
        @include ('errors.list')
    </div>

    {!! Form::model($sponsorRequest, ['route' => ['sponsorRequests.update', $sponsorRequest->id], 'method' => 'patch']) !!}
    @include ('sponsorRequests._form', ['submitButtonText' => 'Update Sponsor'])

@stop

