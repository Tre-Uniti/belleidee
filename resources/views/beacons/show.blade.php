@extends('app')
@section('siteTitle')
    Show Beacon
@stop

@section('centerMenu')
    <h2>{{ $beacon->name }}</h2>
@stop

@section('centerText')

        <div class = "indexNav">
            <a href="{{ url('/belief/index/'. $beacon->belief) }}"><button type = "button" class = "indexButton">{{ $beacon->belief }}</button></a>
            <a href="{{ url('/beacons/tags/'.$beacon->beacon_tag) }}"><button type = "button" class = "indexButton">{{ $beacon->beacon_tag }}</button></a>
            <a href="{{ $beacon->website }}" target="_blank"><button type = "button" class = "indexButton">Website</button></a>
            <a href = "{{ $location }}" target = "_blank"><button type = "button" class = "indexButton">Location</button></a>
        </div>


        <div class = "indexLeft">
            <h4>Top Posts</h4>
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
    <div id = "centerFooter">
        @if($beacon->tier > 0)
            <a href = {{ url('/users/'. $beacon->guide) }}><button type = "button" class = "navButton">Beacon Guide</button></a>
        @endif
        @if($user->type > 1)
            <a href="{{ url('/beacons/'.$beacon->id .'/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
        @endif
        @if($beacon->beacon_tag != 'No-Beacon')
            <a href="{{ url('/bookmarks/beacons/'.$beacon->beacon_tag) }}"><button type = "button" class = "navButton">Bookmark</button></a>
        @endif
    </div>
@stop

