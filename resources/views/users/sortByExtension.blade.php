@extends('app')
@section('siteTitle')
    Users
@stop

@section('centerText')
    <div>
        <h2>User Directory</h2>
        <table style="display: inline-block;">
            <tr>
                <td><a href={{ url('/users/sortByElevation')}}>Top Elevated</a></td>
                <td><a href={{ url('/indev')}}>Search</a></td>
                <td><a href={{ url('/users')}}>Most Recent</a></td>
            </tr>
        </table>
    </div>
    <div style = "width: 50%; float: left;">
        <h4>Handle</h4>
    </div>
    <div style = "width: 50%; float: right;">
        <h4>Joined</h4>
    </div>
    @foreach ($users as $user2)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('UserController@show', [$user2->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $user2->handle }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('UserController@show', [$user2->id])}}"><button type = "button" class = "interactButton">{{ $user2->created_at->format('M-d-Y') }}</button></a>
            </div>
        </div>
    @endforeach
@stop
@section('centerFooter')
    {!! $users->render() !!}
@stop

@include('posts.rightSide')


