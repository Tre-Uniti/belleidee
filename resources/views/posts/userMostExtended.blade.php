@extends('app')
@section('siteTitle')
    User Posts
@stop

@section('centerText')
    <h2>Most Extended Posts by <a href={{ url('/users/'. $user->id)}}>{{ $user->handle }}</a></h2>
    <div class = "indexNav">
        <a href={{ url('posts/user/elevated/'. $user->id)}}><button type = "button" class = "indexButton">Top Elevated</button></a>
        <a href={{ url('/users/'. $user->id)}}><button type = "button" class = "indexButton">Profile</button></a>
        <a href={{ url('posts/user/'. $user->id)}}><button type = "button" class = "indexButton">Recent</button></a>
    </div>
    <div class = "indexLeft">
        <h4>Title</h4>
    </div>
    <div class = "indexRight">
        <h4>Extension</h4>
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
