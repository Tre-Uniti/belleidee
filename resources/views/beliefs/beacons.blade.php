@extends('app')
@section('siteTitle')
    Show Belief
@stop

@section('centerText')
    <h2>{{ $belief }} Beacons</h2>
        <div class = "indexNav">
            <a href={{ url('/beliefs/'. $belief)}}><button type = "button" class = "indexButton">About</button></a>
            <a href={{ url('/beliefs/posts/'. $belief)}}><button type = "button" class = "indexButton">Posts</button></a>
            <a href={{ url('/beliefs/extensions/'. $belief)}}><button type = "button" class = "indexButton">Extensions</button></a>
        </div>

    <hr class = "contentSeparator"/>
    @include('beacons._beaconCards')

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $beacons])
@stop

