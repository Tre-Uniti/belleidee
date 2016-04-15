@extends('app')
@section('siteTitle')
    Beacon Requests
@stop

@section('centerText')
    <div>
    <h2>Recent Beacon Requests</h2>
    <div id = "indexNav">
        <a href={{ url('/beaconRequests/create')}}><button type = "button" class = "indexButton">New Beacon Request</button></a>
        <a href="{{ url('/beaconRequests/agreement')}}" target ="_blank"><button type = "button" class = "indexButton">Beacon Agreement</button></a>
    </div>

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
                <a href="{{ action('BeaconRequestController@show', [$request->id])}}"><button type = "button" class = "interactButtonLeft">{{ $request->name }} </button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('BeaconRequestController@show', [$request->id])}}"><button type = "button" class = "interactButton">{{ $request->created_at->format('M-d-Y')}}</button></a>
            </div>
        </div>
    @endforeach
@stop
@section('centerFooter')
    {!! $beaconRequests->render() !!}
@stop
