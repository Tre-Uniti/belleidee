@extends('app')
@section('siteTitle')
    Your Posts
@stop



@section('centerText')
    <div>
        <h2>Your Posts</h2>
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


