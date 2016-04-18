@extends('app')
@section('siteTitle')
    Posts
@stop

@section('centerText')
    <div>
    <h2>Recent Posts</h2>
    <div class = "indexNav">
        <a href={{ url('/posts/elevation')}}><button type = "button" class = "indexButton">Elevated</button></a>
        <a href={{ url('/posts/search')}}><button type = "button" class = "indexButton">Search</button></a>
        <a href={{ url('/posts/extension')}}><button type = "button" class = "indexButton">Extended</button></a>
    </div>
        <nav class = "infoNav">
            <ul>
                <li>
                    <p class = "extras">/-\</p>
                        <div class = "indexNav">
                            <a href={{ url('/posts/timeFilter/Today')}}><button type = "button" class = "indexButton">Today</button></a>
                            <a href={{ url('/posts/timeFilter/Month') }}><button type = "button" class = "indexButton">Month</button></a>
                            <a href={{ url('/posts/timeFilter/Year')}}><button type = "button" class = "indexButton">Year</button></a>
                            <a href={{ url('/posts/timeFilter/All')}}><button type = "button" class = "indexButton">All-time</button></a>
                        </div>
                </li>
            </ul>
        </nav>
    </div>
    <div class = "indexLeft">
        <h4>Title</h4>
    </div>
    <div class = "indexRight">
        <h4>Handle</h4>
    </div>
        @foreach ($posts as $post)
            <div class = "listResource">
            <div class = "listResourceLeft">
            <a href="{{ action('PostController@show', [$post->id])}}"><button type = "button" class = "interactButtonLeft">{{ $post->title }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('UserController@show', [$post->user_id])}}"><button type = "button" class = "interactButton">{{ $post->user->handle }}</button></a>
            </div>
            </div>
        @endforeach

@stop



