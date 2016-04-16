@extends('app')
@section('siteTitle')
    Getting Started
@stop

@section('centerText')
    <h2>Getting Started</h2>
    <div class = "indexNav">
            <b>Create:</b>
    </div>
    <div class = "indexNav">
        <a href="{{ url('/posts/create') }}"><button type = "button" class = "indexButton">Public post</button></a>
        <a href="{{ url('/drafts/create') }}"><button type = "button" class = "indexButton">Private draft</button></a>
    </div>

    <div class = "indexNav">
            <b>Discover:</b>
    </div>
    <div class = "indexNav">
           <a href="{{ url('/posts') }}"><button type = "button" class = "indexButton">New Posts</button></a>
            <a href="{{ url('/extensions') }}"><button type = "button" class = "indexButton">New Extensions</button></a>
    </div>
    <div class = "indexNav">
            <b>Community:</b>
    </div>
    <div class = "indexNav">
            <a href="{{ url('/beacons') }}"><button type = "button" class = "indexButton">Beacons</button></a>
            <a href = "{{ url('/questions') }}"><button type = "button" class = "indexButton">Questions</button></a>
            <a href="{{ url('/sponsors') }}"><button type = "button" class = "indexButton">Sponsors</button></a>
    </div>
@stop

@section('centerFooter')
    <a href="{{ url('/tutorials') }}"><button type = "button" class = "navButton">Tutorials</button></a>
@stop


