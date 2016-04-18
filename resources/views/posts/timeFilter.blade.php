@extends('app')
@section('siteTitle')
    Posts
@stop

@section('centerText')
        <h2>{{ $filter }} Posts</h2>
        <div class ="indexNav">
              <a href={{ url('/posts/elevationTime/'. $time)}}><button type = "button" class = "indexButton">Elevated</button></a>
               <a href={{ url('/posts/search')}}><button type = "button" class = "indexButton">Search</button></a>
              <a href={{ url('/posts/extensionTime/'.$time)}}><button type = "button" class = "indexButton">Extended</button></a>

        <nav class = "infoNav">
            <ul>
                <li>
                    <a href = {{ url('/posts') }}><button type = "button" class = "indexButton">Recent Posts</button></a>
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

@section('centerFooter')
    {!! $posts->render() !!}
@stop
