@extends('app')
@section('siteTitle')
    Beacons
@stop
@section('centerText')
    <div>
        <h2><a href={{ url('/beacons/'. $beacon->id)}}>Posts of {{$beacon->beacon_tag}}</a></h2>
        <table style="display: inline-block;">
            <tr>
                <td><a href={{ url('/beacons/'. $beacon->id)}}>Profile</a></td>
                <td><a href={{ url('/users/'.$beacon->guide)}}>Guide</a></td>
                <td><a href={{ url('/extensions/beacon/'. $beacon->id)}}>Extensions</a></td>
            </tr>
        </table>
    </div>
    <div style = "width: 50%; float: left;">
        <h4>Title</h4>
    </div>
    <div style = "width: 50%; float: right;">
        <h4>User</h4>
    </div>
    @foreach ($posts as $post)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('PostController@show', [$post->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $post->title }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('UserController@show', [$post->user_id])}}"><button type = "button" class = "interactButton">{{ $post->user->handle }}</button></a>
            </div>
        </div>
    @endforeach
@stop
@section('centerFooter')
    {!! $posts->render() !!}
@stop


