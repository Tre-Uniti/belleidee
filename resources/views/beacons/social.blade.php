@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
@stop
@section('siteTitle')
    Social Beacon
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
        @endif
        <p>Tags this month ({{ $beacon->beacon_tag }}): {{ $beacon->tag_usage }}</p>
    </div>

    <h4>Link to your beacon by following these steps:</h4>
    <ul>
        <li>Download desired logo/image</li>
        <li>Copy and paste the code into your website</li>
        <li>Modify the code to update the image location on your server</li>
    </ul>
    <p>Quick Link to your Beacon: {{ $beaconUrl }}</p>
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

