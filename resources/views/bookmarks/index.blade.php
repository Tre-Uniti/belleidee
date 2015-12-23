@extends('app')
@section('siteTitle')
    Posts
@stop

@include('posts.leftSide')

@section('centerText')
    <div>
    <h2>Bookmarks of {{ $user->handle  }}</h2>
    <table style="display: inline-block;">
        <tr>
            <td><a href={{ url('/posts')}}>Top Elevated</a></td>
            <td><a href={{ url('/posts')}}>Search</a></td>
            <td><a href={{ url('/posts')}}>Most Extended</a></td>
        </tr>
    </table>
    </div>
    <div style = "width: 50%; float: left;">
        <h4>Pointer</h4>
    </div>
    <div style = "width: 50%; float: right;">
        <h4>Type</h4>
    </div>
        @foreach ($bookmarks as $bookmark)
            <div class = "listResource">
                <div class = "listResourceLeft">
                    @if($bookmark['type'] === 'beacon')
                        <a href="{{ action('BeaconController@listTagged', [$bookmark['pointer']])}}">
                           <button type = "button" class = "interactButton" style = "text-align: left;">{{ $bookmark['pointer'] }}</button></a>
                    @elseif($bookmark['type'] === 'post')
                        <a href="{{ action('PostController@show', [$bookmark['pointer']])}}">
                             <button type = "button" class = "interactButton" style = "text-align: left;">{{ $bookmark['pointer'] }}</button></a>
                    @endif
                </div>
                <div class = "listResourceRight">
                    @if($bookmark['type'] === 'beacon')
                        <a href="{{ action('BeaconController@listTagged', [$bookmark['pointer']])}}">
                            <button type = "button" class = "interactButton" style = "text-align: left;">{{ $bookmark['type'] }}</button></a>
                    @elseif($bookmark['type'] === 'post')
                        <a href="{{ action('PostController@show', [$bookmark['pointer']])}}">
                            <button type = "button" class = "interactButton" style = "text-align: left;">{{ $bookmark['type'] }}</button></a>
                    @endif
                </div>
            </div>
        @endforeach
@stop
@section('centerFooter')
@stop

@include('posts.rightSide')


