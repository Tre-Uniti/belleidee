@extends('app')
@section('siteTitle')
    User Beacons
@stop


@section('centerText')
    <div>
    <h2>Beacons of <a href={{ url('/users/'.$user->id)}}>{{$user->handle}}</a></h2>
    <table style="display: inline-block;">
        <tr>
            <td><a href={{ url('/users/elevatedBy/'. $user->id)}}>Elevations</a></td>
            <td><a href={{ url('/users/'.$user->id)}}>Profile</a></td>
            <td><a href={{ url('/users/extendedBy/'. $user->id)}}>Extensions</a></td>
        </tr>
    </table>
    </div>
    <div style = "width: 50%; float: left;">
        <h4>Beacon Tag</h4>
    </div>
    <div style = "width: 50%; float: right;">
        <h4>Bookmarked</h4>
    </div>
    <div class = "listResource">
        @foreach ($bookmarks as $bookmark)

            <div class = "listResource">
                <div style = "width: 50%; text-align: center; float: left; overflow: auto;">
                        <a href="{{ action('BeaconController@listTagged', $bookmark->pointer)}}">
                            <button type = "button" class = "interactButton" style = "text-align: left;">{{ $bookmark->pointer }}</button></a>
                </div>
                <div class = "listResourceRight">
                        <a href="{{ action('BeaconController@listTagged', $bookmark->pointer)}}">
                            <button type = "button" class = "interactButton" style = "text-align: left;">{{ $bookmark->created_at->format('M-d-Y') }}</button></a>
                </div>
            </div>
        @endforeach
    </div>
@stop

@section('centerFooter')
    <div id = "centerFooter">

    </div>
@stop

