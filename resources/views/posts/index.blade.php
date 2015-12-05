@extends('app')
@section('siteTitle')
    Posts
@stop

@include('posts.leftSide')

@section('centerText')
    <h2>Posts</h2>
    <div style = "width: 50%; float: left;">

    <select>
    <option>Top Elevated</option>
    <option>Top Extended</option>
        <option>With Beacon</option>
        <option>Legacy Posts</option>
    </select>
    </div>

    <div style = "width: 50%; float: right;">
    <select>
        <option>Today</option>
        <option>Week</option>
        <option>Month</option>
        <option>2015</option>
    </select>
        </div>

        @foreach ($posts as $post)

            <div style = "width: 35%; float: left; text-align: left; padding-left: 12%; overflow: auto;">
            <a href="{{ action('PostController@show', [$post->id])}}"><button type = "button" class = "interactButton">{{ $post->title }}</button></a>
            </div>
            <div style = "width: 50%; float: right;">
                <a href="{{ action('PostController@show', [$post->id])}}"><button type = "button" class = "interactButton">{{ $post->created_at->format('M-d-Y') }}</button></a>
            </div>
        @endforeach


@stop
@section('centerFooter')
    {!! $posts->render() !!}
@stop

@include('posts.rightSide')


