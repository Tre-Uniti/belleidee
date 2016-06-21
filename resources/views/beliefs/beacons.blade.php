@extends('app')
@section('siteTitle')
    Show Belief
@stop

@section('centerText')
    <h2>{{ $belief }} Beacons</h2>
        <div class = "indexNav">
            <a href={{ url('/beliefs/'. $belief)}}><button type = "button" class = "indexButton">About</button></a>
            <a href={{ url('/beliefs/posts/'. $belief)}}><button type = "button" class = "indexButton">Posts</button></a>
            <a href={{ url('/beliefs/extensions/'. $belief)}}><button type = "button" class = "indexButton">Extensions</button></a>
        </div>

    <div class = "indexLeft">
        <h4>Name</h4>
    </div>
    <div class = "indexRight">
        <h4>Beacon Tag</h4>
    </div>
    @foreach ($beacons as $beacon)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('BeaconController@show', [$beacon->id])}}"><button type = "button" class = "interactButtonLeft">{{ $beacon->name }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('BeaconController@posts', [$beacon->beacon_tag])}}"><button type = "button" class = "interactButton">{{ $beacon->beacon_tag }}</button></a>
            </div>
        </div>
    @endforeach

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $beacons])
@stop

