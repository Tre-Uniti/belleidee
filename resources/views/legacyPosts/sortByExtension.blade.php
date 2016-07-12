@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
@stop
@section('siteTitle')
    Extended Legacy
@stop
@section('centerText')
    <div>
    <h2>Recently Extended Legacy</h2>
    <div class = "indexNav">
        <a href={{ url('/legacyPosts/elevation')}}><button type = "button" class = "indexButton">Elevated</button></a>
        <a href={{ url('/legacyPosts/search')}}><button type = "button" class = "indexButton">Search</button></a>
        <a href={{ url('/legacyPosts')}}><button type = "button" class = "indexButton">New Legacy</button></a>
   </div>
    <button class = "interactButton" id = "hiddenIndex">More</button>
    <div class = "indexContent" id = "hiddenContent">
        <a href={{ url('/legacyPosts/extensionTime/Today')}}><button type = "button" class = "indexButton">Today</button></a>
        <a href = {{ url('/legacyPosts/extensionTime/Month') }}><button type = "button" class = "indexButton">Month</button></a>
        <a href={{ url('/legacyPosts/extensionTime/Year')}}><button type = "button" class = "indexButton">Year</button></a>
        <a href={{ url('/legacyPosts/extensionTime/All')}}><button type = "button" class = "indexButton">All-time</button></a>
    </div>
    </div>
    <div class = "indexLeft">
        <h4>Title</h4>
    </div>
    <div class = "indexRight">
        <h4>Extensions</h4>
    </div>
        @foreach ($extensions as $extension)
            <div class = "listResource">
            <div class = "listResourceLeft">
            <a href="{{ action('LegacyController@show', [$extension->legacy_post_id])}}"><button type = "button" class = "interactButtonLeft">{{ $extension->legacyPost->title }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('LegacyPostController@extensionList', [$extension->legacy_post_id])}}"><button type = "button" class = "interactButton">{{ $extension->legacyPost->extension }}</button></a>
            </div>
            </div>
        @endforeach
@stop



