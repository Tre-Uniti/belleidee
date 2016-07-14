@extends('app')
@section('siteTitle')
    Legacy Posts
@stop

@section('centerText')
    <h2>{{ $filter }} Legacy Posts</h2>

        <div class = "indexNav">
            <a href={{ url('/legacyPosts/elevationTime/'. $time)}}><button type = "button" class = "indexButton">Top Elevated</button></a>
            <a href={{ url('/legacyPosts/search')}}><button type = "button" class = "indexButton">Search</button></a>
            <a href={{ url('/legacyPosts/extensionTime/'.$time)}}><button type = "button" class = "indexButton">Most Extended</button></a>
        </div>
        <nav class = "infoNav">
            <ul>
                <li>
                    <a href = {{ url('/legacyPosts') }}><button type = "button" class = "indexButton">Recent Legacy Posts</button></a>
                </li>
            </ul>
        </nav>
    <div class = "indexLeft">
        <h4>Title</h4>
    </div>
    <div class = "indexRight">
        <h4>Belief</h4>
    </div>

    @foreach ($legacyPosts as $legacyPost)
        <div class = "listResource">
        <div class = "listResourceLeft">
            <a href="{{ action('LegacyPostController@show', [$legacyPost->id])}}"><button type = "button" class = "interactButtonLeft">{{ $legacyPost->title }}</button></a>
        </div>
        <div class = "listResourceRight">
            <a href="{{ action('LegacyPostController@beliefIndex', [$legacyPost->belief])}}"><button type = "button" class = "interactButton">{{ $legacyPost->belief }}</button></a>
        </div>
        </div>
    @endforeach

@stop

@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $legacyPosts])
@stop
