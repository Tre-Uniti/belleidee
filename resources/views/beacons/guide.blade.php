@extends('app')
@section('siteTitle')
    Beacons
@stop
@section('centerText')
    <h2>Guide Posts of <a href={{ url('/beacons/'. $beacon->beacon_tag)}}>{{$beacon->name}}</a></h2>
    <div class = "indexNav">
        <a href={{ url('/beacons/'. $beacon->beacon_tag)}}><button type = "button" class = "indexButton">Profile</button></a>
        <a href={{ url('/beacons/posts/'.$beacon->id)}}><button type = "button" class = "indexButton">User Posts</button></a>
        <a href={{ url('/beacons/extensions/'. $beacon->id)}}><button type = "button" class = "indexButton">Extensions</button></a>
    </div>
    <div class = "indexLeft">
        <h4>Title</h4>
    </div>
    <div class = "indexRight">
        <h4>Created</h4>
    </div>
    @foreach ($posts as $post)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('PostController@show', [$post->id])}}"><button type = "button" class = "interactButtonLeft">{{ $post->title }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('PostController@show', [$post->id])}}"><button type = "button" class = "interactButton">{{ $post->created_at->format('M-d-Y') }}</button></a>
            </div>
        </div>
    @endforeach
@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $posts])
@stop


