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
            <td><a href={{ url('/bookmarks/beacons')}}>Beacons</a></td>
            <td><a href={{ url('/bookmarks/posts')}}>Posts</a></td>
        </tr>
    </table>
    </div>
    <div style = "width: 50%; float: left;">
        <h4>Bookmark</h4>
    </div>
    <div style = "width: 50%; float: right;">
        <h4>Type</h4>
    </div>
        @foreach ($bookmarks as $bookmark)
            <div class = "listResource">
                <div class = "listResourceLeft">
                    @if($bookmark['type'] === 'Beacon')
                        <a href="{{ action('BeaconController@show', [$bookmark['id']])}}">
                           <button type = "button" class = "interactButton" style = "text-align: left;">{{ $bookmark['title'] }}</button></a>
                    @elseif($bookmark['type'] === 'Post')
                        <a href="{{ action('PostController@show', [$bookmark['pointer']])}}">
                             <button type = "button" class = "interactButton" style = "text-align: left;">{{ $bookmark['title'] }}</button></a>
                    @endif
                </div>
                <div class = "listResourceRight">
                    @if($bookmark['type'] === 'Beacon')
                        <a href="{{ action('BeaconController@listTagged', [$bookmark['pointer']])}}">
                            <button type = "button" class = "interactButton" style = "text-align: left;">{{ $bookmark['type'] }}</button></a>
                    @elseif($bookmark['type'] === 'Post')
                        <a href="{{ action('PostController@show', [$bookmark['pointer']])}}">
                            <button type = "button" class = "interactButton" style = "text-align: left;">{{ $bookmark['type'] }}</button></a>
                    @endif
                </div>
            </div>
        @endforeach
@stop
@section('centerFooter')
    {{ $bookmarks->render() }}
@stop


