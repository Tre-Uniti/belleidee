@extends('app')
@section('siteTitle')
    Show Belief
@stop


@section('centerText')
    <h2>{{ $belief->name }}</h2>
    <p>{{ $belief->description }}</p>
        <div class = "indexNav">
            <a href="{{ url('/beliefs/beacons/'. $belief->name) }}"><button type = "button" class = "indexButton">Beacons: {{ $belief->beacons }}</button></a>
            <a href="{{ url('/beliefs/posts/'.$belief->name) }}"><button type = "button" class = "indexButton">Posts: {{ $belief->posts }}</button></a>
            <a href="{{ url('/beliefs/extensions/'.$belief->name) }}"><button type = "button" class = "indexButton">Extensions: {{ $belief->extensions }}</button></a>
        </div>
    <h4>Recent Legacy</h4>
    <div class = "indexLeft">
        <h4>Title</h4>
    </div>
    <div class = "indexRight">
        <h4>Created</h4>
    </div>

    @foreach($legacyPosts as $legacyPost)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href = {{ url('/legacyPosts/'. $legacyPost->id) }}><button type = "button" class = "interactButton">{{ $legacyPost->title }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href = {{ url('/legacyPosts/'. $legacyPost->id) }}><button type = "button" class = "interactButton">{{ $legacyPost->created_at->format('M-d-Y') }}</button></a>
            </div>
        </div>
    @endforeach
@stop

@section('centerFooter')
    <a href="{{ url('/beliefs/') }}"><button type = "button" class = "navButton">Belief Directory</button></a>
    <a href="{{ url('/legacyPosts/belief/'. $belief->name) }}"><button type = "button" class = "navButton">More Legacy</button></a>
    @if($user->type > 2)
        <a href="{{ url('/beliefs/'.$belief->id .'/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
    @endif
@stop