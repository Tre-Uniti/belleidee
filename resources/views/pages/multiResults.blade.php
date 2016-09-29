@extends('app')
@section('siteTitle')
    Global Results
@stop

@section('centerText')
        <h2>Search Results for {{$type}}</h2>
        <div class = "indexNav">
              <a href={{ url('/search')}}><button type = "button" class = "indexButton">New Global Search</button></a>
        </div>

        @foreach ($posts as $post)
            <div class = "listResource">
                <div class = "listResourceLeft">
                    <a href="{{ action('PostController@show', [$post->id])}}"><button type = "button" class = "interactButtonLeft">{{$post->title}}</button></a>
                </div>
                <div class = "listResourceRight">
                    <a href="{{ action('UserController@show', [$post->user_id])}}"><button type = "button" class = "interactButton">{{$post->user->handle}}</button></a>
                </div>
            </div>
        @endforeach
        @foreach ($extensions as $extension)
            <div class = "listResource">
                <div class = "listResourceLeft">
                    <a href="{{ action('ExtensionController@show', [$extension->id])}}"><button type = "button" class = "interactButtonLeft">{{$extension->title}}</button></a>
                </div>
                <div class = "listResourceRight">
                    <a href="{{ action('UserController@show', [$extension->user_id])}}"><button type = "button" class = "interactButton">{{$extension->user->handle}}</button></a>
                </div>
            </div>
        @endforeach

        @foreach ($users as $user)
            <div class = "listResource">
                <div class = "listResourceLeft">
                    <a href="{{ action('UserController@show', [$user->id])}}"><button type = "button" class = "interactButtonLeft">{{$user->handle}}</button></a>
                </div>
                <div class = "listResourceRight">
                    <a href="{{ action('UserController@show', [$user->id])}}"><button type = "button" class = "interactButton">{{$user->created_at->format('M-d-Y')}}</button></a>
                </div>
            </div>
        @endforeach

@stop
@section('centerFooter')

@stop



