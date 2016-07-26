@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
@stop
@section('siteTitle')
    Analytics for Beacon
@stop

@section('centerText')
    <h2>Analytics for {{ $beacon->name }}</h2>
    <div class = "indexNav">
        <a href="{{ url('/beacons/'. $beacon->beacon_tag) }}"><button type = "button" class = "indexButton">Beacon Profile</button></a>
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
                <p>Manager:</p>
                <a href="{{ url('/beacons/invoice/'. $beacon->id )}}"><button type = "button" class = "indexButton">Invoices</button></a>
                <a href="{{ url('/beacons/subscription/'. $beacon->id )}}"><button type = "button" class = "indexButton">Subscription</button></a>
                <a href="{{ url('/intolerances/beacon/'. $beacon->id) }}"><button type = "button" class = "indexButton">Intolerance</button></a>
            </div>
            <div class = "indexNav">
                <a href = "{{ url('/beacons/social/'. $beacon->id) }}"><button type = "button" class = "indexButton">Social Button</button></a>
                <a href = "{{ url('/announcements/beaconIndex/'. $beacon->id) }}"><button type = "button" class = "indexButton">Announcements</button></a>
            </div>
        @endif
        <p>Tags this month ({{ $beacon->beacon_tag }}): {{ $beacon->tag_usage }}</p>
        </div>

    <table>
        <tr>
            <th>Monthly Tags</th>
            <th>Monthly Views</th>
            <th>Total Tag Usage</th>
        </tr>
        <tr>
            <td>{{ $beacon->tag_usage }}</td>
            <td>{{ $beacon->tag_views }}</td>
            <td>{{ $beacon->total_tag_usage }}</td>
        </tr>
    </table>
    <table>
        <tr>
            <th>Guide Posts</th>
            <th>User Posts</th>
            <th>Extensions</tH>
        </tr>
        <tr>
            <td>{{ $guidePosts }}</td>
            <td>{{ $userPosts }}</td>
            <td>{{ $extensions }}</td>
        </tr>
    </table>

@stop

@section('centerFooter')

    @if($user->type > 1)
        <a href="{{ url('/beacons/'.$beacon->id .'/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
    @endif

@stop

