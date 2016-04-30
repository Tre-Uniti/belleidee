@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
@stop
@section('siteTitle')
    Elevated Posts
@stop
@section('centerText')
    <div>
    <h2>Recently Elevated Posts</h2>
    <div class = "indexNav">
        <a href={{ url('/posts')}}><button type = "button" class = "indexButton">New Posts</button></a>
        <a href={{ url('/posts/search')}}><button type = "button" class = "indexButton">Search</button></a>
        <a href={{ url('/posts/extension')}}><button type = "button" class = "indexButton">Extended</button></a>
    </div>
    <button class = "interactButton" id = "hiddenIndex">More</button>
    <div class = "indexContent" id = "hiddenContent">
        <a href={{ url('/posts/elevationTime/Today')}}><button type = "button" class = "indexButton">Today</button></a>
        <a href={{ url('/posts/elevationTime/Month') }}><button type = "button" class = "indexButton">Month</button></a>
        <a href={{ url('/posts/elevationTime/Year')}}><button type = "button" class = "indexButton">Year</button></a>
        <a href={{ url('/posts/elevationTime/All')}}><button type = "button" class = "indexButton">All-time</button></a>
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
                <a href="{{ action('PostController@show', [$elevation->post_id])}}"><button type = "button" class = "interactButtonLeft">{{ $elevation->post->title }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('PostController@listElevation', [$elevation->post_id])}}"><button type = "button" class = "interactButton">{{ $elevation->post->elevation }}</button></a>
            </div>
            </div>
        @endforeach
@stop



