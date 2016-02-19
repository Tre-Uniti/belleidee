@extends('app')
@section('siteTitle')
    Bookmarks
@stop

@section('centerText')
    <div>
    <h2>Bookmarks of {{ $user->handle  }}</h2>
    <table style="display: inline-block;">
        <tr>
            <td><a href={{ url('/bookmarks/users')}}>Users</a></td>
            <td><a href={{ url('/bookmarks')}}>List All</a></td>
            <td><a href={{ url('/bookmarks/posts')}}>Posts</a></td>
            <td><a href={{ url('/bookmarks/extensions')}}>Extensions</a></td>
        </tr>
    </table>
    </div>
    <div style = "width: 50%; float: left;">
        <h4>Name</h4>
    </div>
    <div style = "width: 50%; float: right">
        <div style = "width: 60%; float: left;">
            <h4>Type</h4>
        </div>
        <div style = "width: 40%; float: right;">
            <h4>Remove</h4>
        </div>
    </div>

        @foreach ($bookmarks as $bookmark)
            <div class = "listResource">
                <div class = "listResourceLeft" style = "padding-left: 10%;">
                    <a href="{{ action('BeaconController@show', [$bookmark['id']])}}">
                        <button type = "button" class = "interactButton" style = "text-align: left;">{{ $bookmark['title'] }}</button></a>
                </div>
                <div style = "width: 50%; float: right;">
                <div class = "listResourceRight" style = "float: left; width: 60%;" >
                    <a href="{{ action('BeaconController@listTagged', [$bookmark['pointer']])}}">
                        <button type = "button" class = "interactButton" style = "text-align: left;">{{ $bookmark['type'] }}</button></a>
                </div>
                    <div style = "float: right; width: 40%; ">
                        <a href="{{ action('BookmarkController@remove', [$bookmark['id']])}}">
                            <button type = "button" class = "interactButton">/x\</button></a>
                    </div>
                </div>

            </div>
        @endforeach
@stop
@section('centerFooter')
    {!! $bookmarks->render() !!}
@stop

