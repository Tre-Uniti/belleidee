@extends('app')
@section('siteTitle')
    Elevated Posts
@stop

@section('centerText')
    <h2>Top Elevated Posts ({{ $filter }})</h2>
        <div class = "indexNav">
            <a href={{ url('/posts')}}><button type = "button" class = "indexButton">New Posts</button></a>
            <a href={{ url('/posts/search')}}><button type = "button" class = "indexButton">Search</button></a>
            <a href={{ url('/posts/extensionTime/'. $time)}}><button type = "button" class = "indexButton">Extended</button></a>

        <nav class = "infoNav">
            <ul>
                <li>
                    <a href = {{ url('/posts/elevation') }}><button type = "button" class = "indexButton">Recently Elevated</button></a>
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
        @foreach ($posts as $post)
            <div class = "listResource">
            <div class = "listResourceLeft">
            <a href="{{ action('PostController@show', [$post->id])}}"><button type = "button" class = "interactButtonLeft">{{ $post->title }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('PostController@listElevation', [$post->id])}}"><button type = "button" class = "interactButton">{{ $post->elevation }}</button></a>
            </div>
            </div>
        @endforeach
@stop
@section('centerFooter')
    {!! $posts->render() !!}

@stop



