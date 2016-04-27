@extends('app')
@section('siteTitle')
    User Beacons
@stop


@section('centerText')

    <h2>Beacons of <a href={{ url('/users/'.$user->id)}}>{{$user->handle}}</a></h2>
    <div class = "indexNav">
        <a href={{ url('/users/elevatedBy/'. $user->id)}}><button type = "button" class = "indexButton">Elevated By</button></a>
        <a href={{ url('/users/'.$user->id)}}><button type = "button" class = "indexButton">Profile</button></a>
        <a href={{ url('/users/extendedBy/'. $user->id)}}><button type = "button" class = "indexButton">Extended By</button></a>
    </div>
    <div class = "indexLeft">
        <h4>Beacon Tag</h4>
    </div>
    <div class = "indexRight">
        <h4>Bookmarked</h4>
    </div>
    <div class = "listResource">
        @foreach ($bookmarks as $bookmark)

            <div class = "listResource">
                <div class = "listResourceLeft">
                        <a href="{{ action('BeaconController@listTagged', $bookmark->pointer)}}">
                            <button type = "button" class = "interactButton">{{ $bookmark->pointer }}</button></a>
                </div>
                <div class = "listResourceRight">
                        <a href="{{ action('BeaconController@listTagged', $bookmark->pointer)}}">
                            <button type = "button" class = "interactButton">{{ $bookmark->created_at->format('M-d-Y') }}</button></a>
                </div>
            </div>
        @endforeach
    </div>
@stop


