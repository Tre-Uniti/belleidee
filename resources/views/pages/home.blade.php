@extends('app')
@section('siteTitle')
    Home
@stop

@section('centerText')
    <h2>Home of {{$user->handle}}</h2>
    <div class = "indexNav">
            <b>Creations:</b>
    </div>
    <div class = "indexNav">
        <a href="{{ url('/posts/user/'. $user->id) }}"><button type = "button" class = "indexButton">Posts: {{ $posts }}</button></a>
        <a href="{{ url('/extensions/user/'. $user->id) }}"><button type = "button" class = "indexButton">Extensions: {{ $extensions }}</button></a>
    </div>
    <div class = "indexNav">
        <b>Inspires Others:</b>
        </div>
    <div class = "indexNav">
        <a href="{{ url('/users/elevatedBy/'. $user->id) }}"><button type = "button" class = "indexButton">Elevated: {{ $user->elevation }}</button></a>
        <a href="{{ url('/users/extendedBy/'. $user->id) }}"><button type = "button" class = "indexButton">Extended: {{ $user->extension }}</button></a>
    </div>
    <div class = "indexNav">
        <b>Community Question:</b>
        </div>
    <div class = "indexNav">
        <a href = {{ url('questions/'. $question->id)}}><button type = "button" class = "indexButton">{{ $question->question }}</button></a>
    </div>
@stop

@section('centerFooter')
    <a href="{{ url('/search') }}"><button type = "button" class = "navButton">Search</button></a>
    <a href="{{ url('/bookmarks') }}"><button type = "button" class = "navButton">Bookmarks</button></a>
    <a href="{{ url('/auth/logout') }}"><button type = "button" class = "navButton">Logout</button></a>
@stop
