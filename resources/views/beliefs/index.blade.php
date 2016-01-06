@extends('app')
@section('siteTitle')
    Beliefs
@stop

@section('centerText')
    <div>
    <h2>Belief Directory</h2>
    <table style="display: inline-block;">
        <tr>
            <td><a href={{ url('/indev')}}>Top Elevated</a></td>
            <td><a href={{ url('/indev')}}>Search</a></td>
            <td><a href={{ url('/indev')}}>Most Extended</a></td>
        </tr>
    </table>
    </div>
    <div style = "width: 50%; float: left;">
        <h4>Belief</h4>
    </div>
    <div style = "width: 50%; float: right;">
        <h4>Last Post</h4>
    </div>
    @foreach ($posts as $post)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('BeliefController@beliefIndex', [$post->index])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $post->index }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('PostController@show', [$post->id])}}"><button type = "button" class = "interactButton">{{ $post->title }}</button></a>
            </div>
        </div>
    @endforeach
@stop
@section('centerFooter')
@stop

@include('posts.rightSide')


