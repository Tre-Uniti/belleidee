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

            <div class = "listResource">
            <div class = "listResourceLeft">
            <a href="{{ action('PostController@show', [$post->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $post->title }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('PostController@show', [$post->id])}}"><button type = "button" class = "interactButton">{{ $post->created_at->format('M-d-Y') }}</button></a>
            </div>
            </div>

        @endforeach


@stop
@section('centerFooter')
    {!! $posts->render() !!}
@stop

@include('posts.rightSide')


