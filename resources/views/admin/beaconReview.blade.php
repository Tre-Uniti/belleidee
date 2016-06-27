@extends('app')
@section('siteTitle')
    Beacon Review
@stop

@section('centerText')
    <h2>{{ $beaconRequest->name }}</h2>
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
        Zip code:
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
    <div class = "formLabel">
        User:
    </div>
    <div class = "formShowData">
        {{ $beaconRequest->user->handle }}
    </div>
    <div class = "formLabel">
        Admin:
    </div>
    <div class = "formShowData">
        {{ $beaconRequest->admin }}
    </div>
    <div class = "formLabel">
        Status:
    </div>
    <div class = "formShowData">
        {{ $beaconRequest->status }}
    </div>
@stop

@section('centerFooter')
    <div id = "centerFooter">
        @if($user->type > 1)
            <a href="{{ url('/admin/beacon/edit/'.$beaconRequest->id) }}"><button type = "button" class = "navButton">Edit</button></a>
            <a href="{{ url('/admin/beacon/convert/'.$beaconRequest->id) }}"><button type = "button" class = "navButton">Convert to Beacon</button></a>
                {!! Form::open(['method' => 'DELETE', 'route' => ['beaconRequests.destroy', $beaconRequest->id]]) !!}
                {!! Form::submit('Delete', ['class' => 'navButton', 'id' => 'delete']) !!}
                {!! Form::close() !!}
        @endif
    </div>
@stop

