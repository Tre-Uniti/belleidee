@extends('app')
@section('siteTitle')
    Elevation of Post
@stop

@section('centerText')
    <h2>Elevation of  <a href={{ url('/posts/'. $post->id)}}>{{ $post->title }}</a></h2>
    <div class = "indexNav">
        <a href={{ url('/posts/'. $post->id)}}><button type = "button" class = "indexButton">Back</button></a>
        <a href={{ url('/posts/'. $post->id)}}><button type = "button" class = "indexButton">Total: {{ $post->elevation }}</button></a>
        <a href={{ url('/extensions/post/list/'.$post->id)}}><button type = "button" class = "indexButton">Extensions</button></a>
    </div>
    <div class = "indexLeft">
        <h4>Date</h4>
    </div>
    <div class = "indexRight">
        <h4>Elevated By</h4>
    </div>

    @foreach ($elevations as $elevate)

        <div class = "listResource">
            <div class = "indexLeft">
                <a href="{{ action('PostController@show', [$post->id])}}"><button type = "button" class = "interactButton">{{ $elevate->created_at->format('M-d-Y') }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('UserController@show', [$elevate->user_id])}}"><button type = "button" class = "interactButton">{{ $elevate->user->handle }}</button></a>
            </div>
        </div>
    @endforeach

@stop
@section('centerFooter')
    {!! $elevations->render() !!}
@stop



