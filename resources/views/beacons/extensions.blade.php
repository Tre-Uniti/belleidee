@extends('app')
@section('siteTitle')
    Beacon Extensions
@stop

@section('centerText')
    <h2>Extensions of <a href={{ url('/beacons/tags/'. $beacon->beacon_tag)}}>{{ $beacon->beacon_tag }}</a></h2>
        <div class = "indexNav">
            <a href={{ url('/beacons/'. $beacon->id)}}><button type = "button" class = "indexButton">Profile</button></a>
            <a href={{ url('/beacons/guide/'. $beacon->id)}}><button type = "button" class = "indexButton">Guide Posts</button></a>
            <a href={{ url('/beacons/posts/'.$beacon->beacon_tag)}}><button type = "button" class = "indexButton">User Posts</button></a>
        </div>
    <div class = "indexLeft">
        <h4>Title</h4>
    </div>
    <div class = "indexRight">
        <h4>Handle</h4>
    </div>

    @foreach ($extensions as $extension)

        <div class = "listResource">
        <div class = "listResourceLeft">
            <a href="{{ action('ExtensionController@show', [$extension->id])}}"><button type = "button" class = "interactButtonLeft">{{ $extension->title }}</button></a>
        </div>
        <div class = "listResourceRight">
            <a href="{{ action('UserController@show', [$extension->user_id])}}"><button type = "button" class = "interactButton">{{ $extension->user->handle }}</button></a>
        </div>
        </div>
    @endforeach

@stop

@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $extensions])
    <div>
        <a href = {{ url('/bookmarks/beacons/'. $beacon->beacon_tag) }}><button type = "button" class = "navButton">Bookmark</button></a>
    </div>
@stop
