@extends('app')
@section('siteTitle')
    Top Beacons
@stop

@section('centerText')
    <h2>Top Beacons</h2>
    <div class = "indexNav">
        <a href={{ url('/beacons/')}}><button type = "button" class = "indexButton">All Beacons</button></a>
        <a href={{ url('/beacons/search')}}><button type = "button" class = "indexButton">Beacon Search</button></a>
        <a href={{ url('/search')}}><button type = "button" class = "indexButton">Global Search</button></a>
    </div>
    <div class = "indexLeft">
        <h4>Beacon</h4>
    </div>
    <div class = "indexRight">
        <h4>Beacon Tag</h4>
    </div>
    @foreach ($beacons as $beaconIndex)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('BeaconController@show', [$beaconIndex->id])}}"><button type = "button" class = "interactButtonLeft">{{$beaconIndex->name}}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('BeaconController@listTagged', [$beaconIndex->beacon_tag])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{$beaconIndex->beacon_tag}}</button></a>
            </div>
        </div>
    @endforeach
@stop
@section('centerFooter')
    {!! $beacons->render() !!}
@stop



