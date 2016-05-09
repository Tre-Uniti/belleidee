@extends('app')
@section('siteTitle')
    Beacon Request
@stop

@section('centerMenu')
    <h2>{{ $beaconRequest->name }}</h2>
@stop

@section('centerText')
        <div class = "formLabel">
            Belief:
        </div>
        <div class = "formShowData">
            {{ $beaconRequest->belief }}
        </div>
        <div class = "formLabel">
           Country:
        </div>
        <div class = "formShowData">
            {{ $beaconRequest->country }}
        </div>
        <div class = "formLabel">
            Address:
        </div>
        <div class = "formShowData">
            {{ $beaconRequest->address }}
        </div>
        <div class = "formLabel">
            City:
        </div>
        <div class = "formShowData">
            {{ $beaconRequest->city }}
        </div>
        <div class = "formLabel">
            Zip:
        </div>
        <div class = "formShowData">
            {{ $beaconRequest->zip }}
        </div>
        <div class = "formLabel">
            Phone:
        </div>
        <div class = "formShowData">
            {{ $beaconRequest->phone }}
        </div>
        <div class = "formLabel">
            Email:
        </div>
        <div class = "formShowData">
            {{ $beaconRequest->email }}
        </div>
        <div class = "formLabel">
            Website:
        </div>
        <div class = "formShowData">
            {{ $beaconRequest->website }}
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

