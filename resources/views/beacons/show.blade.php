@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
@stop
@section('siteTitle')
    Show Beacon
@stop

@section('centerText')
    <h2>{{ $beacon->name }}</h2>
        <div class = "indexNav">
            <a href="{{ url('/beliefs/'. $beacon->belief) }}"><button type = "button" class = "indexButton">{{ $beacon->belief }}</button></a>
            <a href = "{{ $location }}" target = "_blank"><button type = "button" class = "indexButton">Location</button></a>
            <a href="{{ $beacon->website }}" target="_blank"><button type = "button" class = "indexButton">Website</button></a>
        </div>
    <div>
        <button class = "interactButton" id = "hiddenIndex">More</button>
    </div>
        <div class = "indexContent" id = "hiddenContent">
            <a href="{{ url('/beacons/guide/'.$beacon->id) }}"><button type = "button" class = "indexButton">Guide Posts</button></a>
            <a href="{{ url('/beacons/posts/'.$beacon->id) }}"><button type = "button" class = "indexButton">User Posts</button></a>
            <a href="{{ url('/beacons/extensions/'.$beacon->id) }}"><button type = "button" class = "indexButton">Extensions</button></a>

            @if($user->type > 1 || $user->id == $beacon->manager)
                <div class = "indexNav">
                    <a href="{{ url('/beacons/invoice/'. $beacon->id )}}"><button type = "button" class = "indexButton">Invoices</button></a>
                    <a href="{{ url('/beacons/subscription/'. $beacon->id )}}"><button type = "button" class = "indexButton">Subscription</button></a>
                    <a href="{{ url('/intolerances/beacon/'. $beacon->id) }}"><button type = "button" class = "indexButton">Intolerance</button></a>
                </div>
                <div class = "indexNav">
                   <a href = "{{ url('/beacons/social/'. $beacon->id) }}"><button type = "button" class = "indexButton">Add Social Button/Link</button></a>
                </div>
            @endif
            <p>Tags this month ({{ $beacon->beacon_tag }}): {{ $beacon->tag_usage }}</p>
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
        <a href = {{ url('/users/'. $beacon->guide) }}><button type = "button" class = "navButton">Guide</button></a>

        @if($user->type > 1)
            <a href="{{ url('/beacons/'.$beacon->id .'/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
            <a href="{{ url('beacons/deactivate/'. $beacon->id)}}"><button type = "button" class = "navButton">Deactivate</button></a>
        @endif
        @if($beacon->beacon_tag != 'No-Beacon')
            <a href="{{ url('/bookmarks/beacons/'.$beacon->beacon_tag) }}"><button type = "button" class = "navButton">Bookmark</button></a>
        @endif
    </div>
@stop

