@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
@stop
@section('siteTitle')
    Elevated Legacy
@stop
@section('centerText')
    <div>
    <h2>Recently Elevated Legacy</h2>
    <div class = "indexNav">
        <a href={{ url('/legacyPosts')}}><button type = "button" class = "indexButton">New Legacy</button></a>
        <a href={{ url('/legacyPosts/search')}}><button type = "button" class = "indexButton">Search</button></a>
        <a href={{ url('/legacyPosts/extension')}}><button type = "button" class = "indexButton">Extended</button></a>
    </div>
    <button class = "interactButton" id = "hiddenIndex">More</button>
    <div class = "indexContent" id = "hiddenContent">
        <a href={{ url('/legacyPosts/elevationTime/Today')}}><button type = "button" class = "indexButton">Today</button></a>
        <a href={{ url('/legacyPosts/elevationTime/Month') }}><button type = "button" class = "indexButton">Month</button></a>
        <a href={{ url('/legacyPosts/elevationTime/Year')}}><button type = "button" class = "indexButton">Year</button></a>
        <a href={{ url('/legacyPosts/elevationTime/All')}}><button type = "button" class = "indexButton">All-time</button></a>
    </div>
    </div>
    <div class = "indexLeft">
        <h4>Title</h4>
    </div>
    <div class = "indexRight">
        <h4>Elevation</h4>
    </div>
        @foreach ($elevations as $elevation)
            <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('LegacyPostController@show', [$elevation->legacy_post_id])}}"><button type = "button" class = "interactButtonLeft">{{ $elevation->legacypost['title'] }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('LegacyPostController@listElevation', [$elevation->legacy_post_id])}}"><button type = "button" class = "interactButton">{{ $elevation->legacyPost['elevation']}}</button></a>
            </div>
            </div>
        @endforeach
@stop



