@extends('app')
@section('siteTitle')
    Beacon Requests
@stop

@section('centerText')
        <h2>Recent Beacon Requests</h2>
        <div class = "indexNav">
            <a href={{ url('/beacons/create')}}><button type = "button" class = "indexButton">New Beacon</button></a>
            <a href={{ url('/beacon/runMonthly')}}><button type = "button" class = "indexButton">Run Monthly</button></a>
            <a href={{ url('/beaconRequests/create')}}><button type = "button" class = "indexButton">New Request</button></a>
        </div>

    <div class = "indexLeft">
        <h4>Name</h4>
    </div>
    <div class = "indexRight">
        <h4>Created</h4>
    </div>
    @foreach ($beaconRequests as $request)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('AdminController@reviewBeaconRequest', [$request->id])}}"><button type = "button" class = "interactButtonLeft" style = "text-align: left;">{{ $request->name }} </button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('AdminController@reviewBeaconRequest', [$request->id])}}"><button type = "button" class = "interactButton">{{ $request->status}}</button></a>
            </div>
        </div>
    @endforeach
@stop
@section('centerFooter')
    {!! $beaconRequests->render() !!}
@stop
