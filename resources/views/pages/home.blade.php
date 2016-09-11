@extends('app')
@section('siteTitle')
    Home
@stop

@section('centerText')
    <h2>Home of {{$user->handle}}</h2>

    <div class = "indexNav">
        <div class = "contentNavTitle">
            Your Creations:
        </div>
            <a href="{{ url('/posts/user/'. $user->id) }}"><button type = "button" class = "indexButton">Posts: {{ $posts }}</button></a>
            <a href="{{ url('/extensions/user/'. $user->id) }}"><button type = "button" class = "indexButton">Extensions: {{ $extensions }}</button></a>
    </div>

    <div class = "indexNav">
        <div class = "contentNavTitle">
            Your Influence:
        </div>
            <div class = "indexLink">
                <a href="{{ url('/users/elevatedBy/'. $user->id) }}"><img src = "/img/elevate.png"> {{ $user->elevation }}</a>
            </div>
            <div class = "indexLink">
                <a href="{{ url('/users/extendedBy/'. $user->id) }}"><img src = "/img/extend.png"> {{ $user->extension }}</a>
            </div>
    </div>

    <div class = "contentNavTitle">
        Community Question
        </div>
    <div id = "questionContainer">
        <div class = "indexLink">
            <a href = {{ url('questions/'. $question->id)}}>{{ $question->question }}</a>
        </div>
    </div>

    <h4>Content from Bookmarks:</h4>

@stop

@section('centerFooter')
    <a href="{{ url('/search') }}"><button type = "button" class = "navButton">Search</button></a>
    <a href="{{ url('/bookmarks') }}"><button type = "button" class = "navButton">Bookmarks</button></a>
    <a href="{{ url('/auth/logout') }}"><button type = "button" class = "navButton">Logout</button></a>
@stop
