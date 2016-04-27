@extends('app')
@section('siteTitle')
    Home
@stop

@section('centerText')
    <h2>Home of {{$user->handle}}</h2>
    <div class = "contentNav">
        <div class = "contentNavTitle">
            Creations
            </div>
        <div class = "contentNavLeft">
            <a href="{{ url('/posts/user/'. $user->id) }}"><button type = "button" class = "indexButton">Posts: {{ $posts }}</button></a>
        </div>
        <div class = "contentNavLeft">
            <a href="{{ url('/extensions/user/'. $user->id) }}"><button type = "button" class = "indexButton">Extensions: {{ $extensions }}</button></a>
        </div>
    </div>

    <div class = "contentNav">
        <div class = "contentNavTitleLeft">
            Interactions
            </div>
        <div class = "contentNavRight">
            <a href="{{ url('/users/elevatedBy/'. $user->id) }}"><button type = "button" class = "indexButton">Elevated: {{ $user->elevation }}</button></a>
        </div>
        <div class = "contentNavRight">
            <a href="{{ url('/users/extendedBy/'. $user->id) }}"><button type = "button" class = "indexButton">Extended: {{ $user->extension }}</button></a>
        </div>
    </div>
    <div class = "contentNavTitle">
        Community Question
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
