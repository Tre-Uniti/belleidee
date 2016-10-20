@extends('app')
@section('siteTitle')
    Show Belief
@stop


@section('centerText')
    <h2>{{ $belief }} Posts</h2>
    <div class = "indexNav">
        <a href={{ url('/beliefs/beacons/'. $belief)}}><button type = "button" class = "indexButton">Beacons</button></a>
        <a href={{ url('/beliefs/'. $belief)}}><button type = "button" class = "indexButton">About</button></a>
        <a href={{ url('/beliefs/extensions/'. $belief)}}><button type = "button" class = "indexButton">Extensions</button></a>
    </div>
    <hr class = "contentSeparator"/>
    @include('posts._postCards')

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $posts])
@stop


