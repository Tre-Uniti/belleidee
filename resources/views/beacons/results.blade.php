@extends('app')
@section('siteTitle')
    Search Beacons
@stop

@section('centerText')
        <h2>Search Results</h2>
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
        @foreach ($results as $result)
            <div class = "listResource">
                <div class = "listResourceLeft">
                    <a href="{{ action('BeaconController@show', [$result->id])}}"><button type = "button" class = "interactButtonLeft">{{$result->name}}</button></a>
                </div>
                <div class = "listResourceRight">
                    <a href="{{ action('BeaconController@listTagged', [$result->beacon_tag])}}"><button type = "button" class = "interactButton">{{$result->beacon_tag}}</button></a>
                </div>
            </div>
        @endforeach

@stop
@section('centerFooter')
    {!! $results->appends(['identifier' => $identifier])->render() !!}
@stop



