@extends('app')
@section('siteTitle')
    Show Belief
@stop


@section('centerText')
    <h2>{{ $belief }} Posts</h2>
    <div class = "indexNav">
        <a href={{ url('/beliefs/beacons/'. $belief)}}><button type = "button" class = "indexButton">Beacons</button></a>
        <a href={{ url('/beliefs/'. $belief)}}><button type = "button" class = "indexButton">About</button></a>
        <a href={{ url('/beliefs/extensions/'. $belief)}}><button type = "button" class = "indexButton">Extensions</button></a>
    </div>
    <div class = "indexLeft">
        <h4>Title</h4>
    </div>
    <div class = "indexRight">
        <h4>User</h4>
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
    @include('pagination.custom-paginator', ['paginator' => $posts])
@stop


