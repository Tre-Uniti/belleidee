@extends('app')
@section('siteTitle')
    Extended Posts
@stop
@section('centerText')
    <h2>Recently Extended Posts</h2>
    <div class = "indexNav">
        <a href={{ url('/posts/elevation')}}><button type = "button" class = "indexButton">Elevated</button></a>
        <a href={{ url('/posts/search')}}><button type = "button" class = "indexButton">Search</button></a>
        <a href={{ url('/posts')}}><button type = "button" class = "indexButton">New Posts</button></a>
   </div>
        <nav class = "infoNav">
            <ul>
                <li>
                    <p class = "extras">/-\</p>
                    <div class = "indexNav">
                        <a href={{ url('/posts/extensionTime/Today')}}><button type = "button" class = "indexButton">Today</button></a>
                        <a href = {{ url('/posts/extensionTime/Month') }}><button type = "button" class = "indexButton">Month</button></a>
                        <a href={{ url('/posts/extensionTime/Year')}}><button type = "button" class = "indexButton">Year</button></a>
                        <a href={{ url('/posts/extensionTime/All')}}><button type = "button" class = "indexButton">All-time</button></a>
                    </div>
                </li>
            </ul>
        </nav>
    <div class = "indexLeft">
        <h4>Title</h4>
    </div>
    <div class = "indexRight">
        <h4>Extensions</h4>
    </div>
        @foreach ($extensions as $extension)
            <div class = "listResource">
            <div class = "listResourceLeft">
            <a href="{{ action('PostController@show', [$extension->post_id])}}"><button type = "button" class = "interactButtonLeft">{{ $extension->post->title }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('ExtensionController@postList', [$extension->post_id])}}"><button type = "button" class = "interactButton">{{ $extension->post->extension }}</button></a>
            </div>
            </div>
        @endforeach
@stop



