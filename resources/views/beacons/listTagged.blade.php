@extends('app')
@section('siteTitle')
    Beacons
@stop
@section('centerText')
    <h2><a href={{ url('/beacons/'. $beacon->id)}}>Posts of {{$beacon->beacon_tag}}</a></h2>
    <div class = "indexNav">
        <a href={{ url('/beacons/'. $beacon->id)}}><button type = "button" class = "indexButton">Profile</button></a>
        @if($beacon->tier > 0)
        <a href={{ url('/users/'.$beacon->guide)}}><button type = "button" class = "indexButton">Guide</button></a>
        @endif
        <a href={{ url('/extensions/beacon/'. $beacon->id)}}><button type = "button" class = "indexButton">Extensions</button></a>
    </div>
    <div class = "indexLeft">
        <h4>Title</h4>
    </div>
    <div class = "indexRight">
        <h4>User</h4>
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
    {!! $posts->render() !!}
@stop


