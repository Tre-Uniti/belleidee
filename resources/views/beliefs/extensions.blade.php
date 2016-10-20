@extends('app')
@section('siteTitle')
    Show Belief
@stop

@section('centerText')
    <h2>{{ $belief }} Extensions</h2>
    <div class = "indexNav">
        <a href={{ url('/beliefs/beacons/'. $belief)}}><button type = "button" class = "indexButton">Beacons</button></a>
        <a href={{ url('/beliefs/posts/'. $belief)}}><button type = "button" class = "indexButton">Posts</button></a>
        <a href={{ url('/beliefs/'. $belief)}}><button type = "button" class = "indexButton">About</button></a>
    </div>
    <hr class = "contentSeparator"/>
    @include('extensions._extensionCards')

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $extensions])
@stop

