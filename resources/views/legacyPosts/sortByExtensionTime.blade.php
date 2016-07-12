@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
@stop
@section('siteTitle')
    Extended Legacy
@stop
@section('centerText')
    <div>
    <h2>Most Extended Legacy ({{$filter}})</h2>
    <div class = "indexNav">
        <a href={{ url('/legacyPosts/elevationTime/'. $time)}}><button type = "button" class = "indexButton">Elevated</button></a>
        <a href={{ url('/legacyPosts/search')}}><button type = "button" class = "indexButton">Search</button></a>
        <a href={{ url('/legacyPosts')}}><button type = "button" class = "indexButton">New Legacy</button></a>
        </div>
        <nav class = "infoNav">
            <ul>
                <li>
                    <a href = {{ url('/legacyPosts/elevation') }}><button type = "button" class = "indexButton">Recently Elevated</button></a>
                </li>
            </ul>
        </nav>
    </div>

    <div class = "indexLeft">
        <h4>Title</h4>
    </div>
    <div class = "indexRight">
        <h4>Extensions</h4>
    </div>
        @foreach ($legacyPosts as $legacyPost)
            <div class = "listResource">
            <div class = "listResourceLeft">
            <a href="{{ action('LegacyPostController@show', [$legacyPost->id])}}"><button type = "button" class = "interactButtonLeft">{{ $legacyPost->title }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('LegacyPostController@listExtension', [$legacyPost->id])}}"><button type = "button" class = "interactButton">{{ $legacyPost->extension }}</button></a>
            </div>
            </div>
        @endforeach
@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $legacyPosts])
@stop



