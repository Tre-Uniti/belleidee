@extends('app')
@section('siteTitle')
    Discover
@stop

@include('posts.leftSide')

@section('centerText')
    <h2>Discover New Posts</h2>
    <h4>Sort by:</h4>
<select>
    <option>Oldest</option>
    <option>Newest</option>
    <option>Most Elevated</option>
    <option>Most Extended</option>
</select>
    <select>
        <option>Today</option>
        <option>Week</option>
        <option>Month</option>
        <option>Year</option>
    </select>
<hr/>
        @foreach ($posts as $post)
            <a href="{{ action('PostController@show', [$post->id])}}"><button type = "button" class = "interactButton">{{ $post->title }}</button></a>

        @endforeach



@stop
@section('centerFooter')

@stop

@include('posts.rightSide')


