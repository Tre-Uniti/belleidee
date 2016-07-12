@extends('app')
@section('siteTitle')
    Elevated Legacy
@stop

@section('centerText')
    <h2>Top Elevated Legacy ({{ $filter }})</h2>
        <div class = "indexNav">
            <a href={{ url('/legacyPosts')}}><button type = "button" class = "indexButton">New Posts</button></a>
            <a href={{ url('/legacyPosts/search')}}><button type = "button" class = "indexButton">Search</button></a>
            <a href={{ url('/legacyPosts/extensionTime/'. $time)}}><button type = "button" class = "indexButton">Extended</button></a>

        <nav class = "infoNav">
            <ul>
                <li>
                    <a href = {{ url('/$legacyPost/elevation') }}><button type = "button" class = "indexButton">Recently Elevated</button></a>
                </li>
            </ul>
        </nav>
    </div>

    <div class = "indexLeft">
        <h4>Title</h4>
    </div>
    <div class = "indexRight">
        <h4>Elevation</h4>
    </div>
        @foreach ($legacyPosts as $legacyPost)
            <div class = "listResource">
            <div class = "listResourceLeft">
            <a href="{{ action('LegacyPostController@show', [$legacyPost->id])}}"><button type = "button" class = "interactButtonLeft">{{ $legacyPost->title }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('LegacyPostController@listElevation', [$legacyPost->id])}}"><button type = "button" class = "interactButton">{{ $legacyPost->elevation }}</button></a>
            </div>
            </div>
        @endforeach
@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $legacyPosts])

@stop



