@extends('app')
@section('siteTitle')
    Beacons
@stop

@section('centerText')
    <h2>Beacon Directory</h2>
        <p>Beacon: A place of worship or thought</p>
        <div class = "indexNav">
            <a href={{ url('/beacons/top')}}><button type = "button" class = "indexButton">Top Beacons</button></a>
            <a href={{ url('/beacons/search')}}><button type = "button" class = "indexButton">Search</button></a>
            <a href={{ url('/beaconRequests')}}><button type = "button" class = "indexButton">New Requests</button></a>
        </div>
    <div class = "indexLeft">
        <h4>Name</h4>
    </div>
    <div class = "indexRight">
        <h4>Tag</h4>
    </div>

        @foreach ($beacons as $beaconIndex)
            <div class = "listResource">
            <div class = "listResourceLeft">
            <a href="{{ action('BeaconController@show', [$beaconIndex->id])}}"><button type = "button" class = "interactButtonLeft">{{ $beaconIndex->name }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('BeaconController@listTagged', [$beaconIndex->beacon_tag])}}"><button type = "button" class = "interactButton">{{ $beaconIndex->beacon_tag }}</button></a>
            </div>
            </div>
        @endforeach

@stop
@section('centerFooter')
    {!! $beacons->render() !!}
@stop



