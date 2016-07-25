@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
@stop
@section('siteTitle')
    Top Tagged Beacons
@stop

@section('centerText')
    <div>
    <h2>{{ $location }} Top Tagged Beacons</h2>
    <div class = "indexNav">
        <a href={{ url('/beacons/')}}><button type = "button" class = "indexButton">All Beacons</button></a>
        <a href={{ url('/beacons/search')}}><button type = "button" class = "indexButton">Beacon Search</button></a>
        <a href={{ url('/beaconRequests')}}><button type = "button" class = "indexButton">New Requests</button></a>
    </div>
    <button class = "interactButton" id = "hiddenIndex">More</button>
    <div class = "indexContent" id = "hiddenContent">
        <a href={{ url('/beacons/joinDate')}}><button type = "button" class = "indexButton">Join Date</button></a>
        <a href={{ url('/beacons/topViewed')}}><button type = "button" class = "indexButton">Top Viewed</button></a>
    </div>
    </div>
    <div class = "indexLeft">
        <h4>Beacon</h4>
    </div>
    <div class = "indexRight">
        <h4>Total Tag Usage</h4>
    </div>
    @foreach ($beacons as $beaconIndex)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('BeaconController@show', [$beaconIndex->beacon_tag])}}"><button type = "button" class = "interactButtonLeft">{{$beaconIndex->name}}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('BeaconController@show', [$beaconIndex->beacon_tag])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{$beaconIndex->total_tag_usage}}</button></a>
            </div>
        </div>
    @endforeach
@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $beacons])
@stop



