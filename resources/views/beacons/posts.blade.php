@extends('app')
@section('siteTitle')
    Beacons
@stop
@section('centerText')
    <h2>User Posts of <a href={{ url('/beacons/'. $beacon->id)}}>{{$beacon->name}}</a></h2>
    <div class = "indexNav">
        <a href={{ url('/beacons/'. $beacon->id)}}><button type = "button" class = "indexButton">Profile</button></a>
        <a href={{ url('/beacons/guide/'.$beacon->id)}}><button type = "button" class = "indexButton">Guide Posts</button></a>
        <a href={{ url('/beacons/extensions/'. $beacon->id)}}><button type = "button" class = "indexButton">Extensions</button></a>

    </div>
    <div class = "indexLeft">
        <h4>Title</h4>
    </div>
    <div class = "indexRight">
        <h4>Handle</h4>
    </div>
    @foreach ($posts as $post)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('PostController@show', [$post->id])}}"><button type = "button" class = "interactButtonLeft">{{ $post->title }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('UserController@show', [$post->user_id])}}"><button type = "button" class = "interactButton">{{ $post->user->handle }}</button></a>
            </div>
        </div>
    @endforeach
@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $posts])
    <div>
        <a href = {{ url('/bookmarks/beacons/'. $beacon->beacon_tag) }}><button type = "button" class = "navButton">Bookmark</button></a>
    </div>

@stop


