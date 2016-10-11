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
    <div class = "indexNav">
        <a href="{{ url('/beacons/guide/'.$beacon->beacon_tag)}}" class = "indexLink">Guide</a>
        <a href="{{ url('/beacons/posts/'.$beacon->beacon_tag)}}" class = "indexLink">Posts</a>
        <a href="{{ url('/beacons/extensions/'. $beacon->beacon_tag)}}" class = "indexLink">Extensions</a>
        <a href="{{ url('/beacons/users/'. $beacon->beacon_tag)}}" class = "indexLink">Users</a>
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
                    <a href = "{{ url('/beacons/analytics/'. $beacon->id) }}"><button type = "button" class = "indexButton">Analytics</button></a>
                   <a href = "{{ url('/beacons/integration/'. $beacon->id) }}"><button type = "button" class = "indexButton">Integration</button></a>
                   <a href = "{{ url('/announcements/beaconIndex/'. $beacon->id) }}"><button type = "button" class = "indexButton">Announcements</button></a>
                </div>
            @endif
            <p>Tags this month ({{ $beacon->beacon_tag }}): {{ $beacon->tag_usage }}</p>

        </div>
        <div class = "indexLeft">
            <h4>Announcement</h4>
        </div>
        <div class = "indexRight">
            <h4>Created</h4>
        </div>

        @if(!count($announcements))
            <p>No announcements to show</p>
        @else
        @foreach ($announcements as $announcement)
            <div class = "listResource">
                <div class = "listResourceLeft">
                    <a href="{{ action('AnnouncementController@show', [$announcement->id])}}"><button type = "button" class = "interactButtonLeft">{{ $announcement->title }}</button></a>
                </div>
                <div class = "listResourceRight">
                    <a href="{{ action('AnnouncementController@show', [$announcement->id])}}"><button type = "button" class = "interactButton">{{ $announcement->created_at->format('M-d-Y') }}</button></a>
                </div>
            </div>
        @endforeach
    @endif
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

