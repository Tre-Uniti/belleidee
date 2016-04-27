@extends('app')
@section('siteTitle')
    Your Posts
@stop

@section('centerText')
    <h2>Posts by <a href={{ url('/users/'. $user->id)}}>{{ $user->handle }}</a></h2>
        <div class = "indexNav">
            <a href={{ url('/users/elevatedBy/'.$user->id)}}><button type = "button" class = "indexButton">Elevated By</button></a>
            <a href={{ url('/users/'.$user->id)}}><button type = "button" class = "indexButton">Profile</button></a>
            <a href={{ url('/extensions/user/'. $user->id)}}><button type = "button" class = "indexButton">Extensions</button></a>
    </div>
    <div class = "indexLeft">
        <h4>Title</h4>
    </div>
    <div class = "indexRight">
        <h4>Date</h4>
    </div>

    @foreach ($posts as $post)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('PostController@show', [$post->id])}}"><button type = "button" class = "interactButtonLeft">{{ $post->title }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('PostController@listDates', [$post->created_at])}}"><button type = "button" class = "interactButton">{{ $post->created_at->format('M-d-Y') }}</button></a>
            </div>
        </div>
    @endforeach

@stop
@section('centerFooter')
    {!! $posts->render() !!}
@stop



