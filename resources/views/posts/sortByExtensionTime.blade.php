@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
@stop
@section('siteTitle')
    Extended Posts
@stop
@section('centerText')
    <div>
    <h2>Most Extended Posts ({{$filter}})</h2>
    <div class = "indexNav">
        <a href={{ url('/posts/elevationTime/'. $time)}}><button type = "button" class = "indexButton">Elevated</button></a>
        <a href={{ url('/posts/search')}}><button type = "button" class = "indexButton">Search</button></a>
        <a href={{ url('/posts')}}><button type = "button" class = "indexButton">New Posts</button></a>
        </div>
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
        <h4>Extensions</h4>
    </div>
        @foreach ($posts as $post)
            <div class = "listResource">
            <div class = "listResourceLeft">
            <a href="{{ action('PostController@show', [$post->id])}}"><button type = "button" class = "interactButtonLeft">{{ $post->title }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('ExtensionController@postList', [$post->id])}}"><button type = "button" class = "interactButton">{{ $post->extension }}</button></a>
            </div>
            </div>
        @endforeach
@stop
@section('centerFooter')
    {!! $posts->render() !!}
@stop



