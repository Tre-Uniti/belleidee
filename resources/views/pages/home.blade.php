@extends('app')
@section('siteTitle')
    Home
@stop

@section('centerText')
    <h2>Home of {{$user->handle}}</h2>
    <a href="{{ url('/users/elevatedBy/'. $user->id) }}"><button type = "button" class = "interactButton">Elevation: {{ $user->elevation }}</button></a>
    <a href="{{ url('/users/extendedBy/'. $user->id) }}"><button type = "button" class = "interactButton">Extension: {{ $user->extension }}</button></a>
    <hr/>
    <div style = "width: 50%; float: left;">
        <h2>Post</h2>
    </div>
    <div style = "width: 50%; float: right;">
        <h2>Beacon</h2>
    </div>
    <div class = "listResource">
        @foreach ($posts as $post)
            <div class = "listResource">
                <div class = "listResourceLeft">
                    <a href="{{ action('PostController@show', [$post->post_id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $post->title }}</button></a>
                </div>
                <div class = "listResourceRight">
                    <a href="{{ action('BeaconController@listTagged', [$post->beacon_tag])}}"><button type = "button" class = "interactButton">{{ $post->beacon_tag }}</button></a>
                </div>
            </div>
        @endforeach
    </div>
@stop
@section('centerFooter')
    <a href="{{ url('/bookmarks/personal') }}"><button type = "button" class = "navButton">Bookmarks</button></a>
        <a href="{{ url('/auth/logout') }}"><button type = "button" class = "navButton">Logout</button></a>
@stop
@section('rightSideBar')
    <h2>Hosted</h2>

    <div class = "innerPhotos">
        <a href="/"><img src={{asset('img/idee.png')}} alt="idee" height = "97%" width = "85%"></a>
    </div>
@stop
