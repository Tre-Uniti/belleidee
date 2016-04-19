@extends('app')
@section('siteTitle')
    Beacon Request
@stop

@section('centerMenu')
    <h2>{{ $beaconRequest->name }}</h2>
@stop

@section('centerText')
    <div class = "formDataContainer">
        <div class = "formInput">
            <b>Belief: </b>
            {{ $beaconRequest->belief }}
        </div>
        <div class = "formInput">
            <b>Country:</b>
            {{ $beaconRequest->country }}
        </div>
        <div class = "formInput">
            <b>Address: </b>
            {{ $beaconRequest->address }}
        </div>
        <div class = "formInput">
            <b>City or Region:</b>
            {{ $beaconRequest->location }}
        </div>
        <div class = "formInput">
            <b>Phone:</b>
            {{ $beaconRequest->phone }}
        </div>
        <div class = "formInput">
            <b>Email:</b>
            {{ $beaconRequest->email }}
        </div>
        <div class = "formInput">
            <b>Website:</b>
            {{ $beaconRequest->website }}
        </div>
        <div class = "formInput">

        </div>
        <div class = "formInput">

        </div>
        <div class = "formInput">

        </div>














    </div>
@stop

@section('centerFooter')
    <div id = "centerFooter">
        <a href="{{ url('/beaconRequests/') }}"><button type = "button" class = "navButton">Requests</button></a>
        @if($beaconRequest->user_id == $user->id)
            <a href="{{ url('/beaconRequests/'.$beaconRequest->id .'/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
        @endif
        @if($user->type > 1)
                <a href="{{ url('/admin/beacon/review/'.$beaconRequest->id) }}"><button type = "button" class = "navButton">Review</button></a>
        @endif
    </div>
@stop

