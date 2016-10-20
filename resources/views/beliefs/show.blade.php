@extends('app')
@section('siteTitle')
    Show Belief
@stop


@section('centerText')
    <h2>{{ $belief->name }}</h2>
    <p>{{ $belief->description }}</p>
        <div class = "indexNav">
            <a href="{{ url('/beliefs/posts/'. $belief->name) }}" class = "indexLink">Posts <div>{{ $belief->posts }}</div></a>
            <a href="{{ url('/beliefs/extensions/'. $belief->name) }}" class = "indexLink">Extensions <div>{{ $belief->extensions }}</div></a>
            <a href="{{ url('/beliefs/beacons/'. $belief->name) }}" class = "indexLink">Beacons <div>{{ $belief->beacons }}</div></a>
        </div>
    <div class = "contentHeaderSeparator">
        <h3>
            Legacy Posts
        </h3>
    </div>
    @include('legacyPosts._legacyPostCards')
@stop

@section('centerFooter')
    <a href="{{ url('/beliefs/') }}"><button type = "button" class = "navButton">Belief Directory</button></a>
    <a href="{{ url('/legacyPosts/belief/'. $belief->name) }}"><button type = "button" class = "navButton">More Legacy</button></a>
    @if($user->type > 2)
        <a href="{{ url('/beliefs/'.$belief->id .'/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
    @endif
@stop