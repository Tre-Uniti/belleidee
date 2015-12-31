@extends('app')
@section('siteTitle')
    Your Posts
@stop

@include('posts.leftSide')

@section('centerText')
    <div>
        <h2>Posts by {{ $user->handle }}</h2>
        <table style="display: inline-block;">
            <tr>
                <td><a href={{ url('/posts')}}>Top Elevated</a></td>
                <td><a href={{ url('/posts')}}>Search</a></td>
                <td><a href={{ url('/posts')}}>Most Extended</a></td>
            </tr>
        </table>
    </div>
    <div style = "width: 50%; float: left;">
        <h4>Title</h4>
    </div>
    <div style = "width: 50%; float: right;">
        <h4>Date</h4>
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


