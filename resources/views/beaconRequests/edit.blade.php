@extends('app')
@section('siteTitle')
    Edit Beacon Request
@stop

@section('centerText')
    <div class = "errors">
        @include ('errors.list')
    </div>

    {!! Form::model($beaconRequest, ['route' => ['beaconRequests.update', $beaconRequest->id], 'method' => 'patch']) !!}
    @include ('beaconRequests._edit', ['submitButtonText' => 'Update Beacon'])

@stop
