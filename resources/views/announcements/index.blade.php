@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
@stop
@section('siteTitle')
    Announcements
@stop

@section('centerText')
    <h2>{{ $location }} Beacon Announcements</h2>
    <div class = "indexNav">
    <a href={{ url('/beacons')}}><button type = "button" class = "indexButton">Beacon Directory</button></a>
    </div>
    <div class = "indexLeft">
        <h4>Title</h4>
    </div>
    <div class = "indexRight">
        <h4>Beacon Tag</h4>
    </div>
    @foreach ($announcements as $announcement)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('AnnouncementController@show', [$announcement->id])}}"><button type = "button" class = "interactButtonLeft">{{ $announcement->title }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('BeaconController@show', [$announcement->beacon->beacon_tag])}}"><button type = "button" class = "interactButton">{{ $announcement->beacon->beacon_tag }}</button></a>
            </div>
        </div>
    @endforeach

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $announcements])
@stop