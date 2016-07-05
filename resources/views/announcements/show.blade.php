@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
@stop
@section('siteTitle')
    Show Announcement
@stop

@section('centerText')
    <h2> {{ $announcement->title }}</h2>
    <div class = "indexNav">
        <a href = "{{ url('/beacons/'. $beacon->beacon_tag) }}"><button type = "button" class = "indexButton">Beacon Profile</button></a>
        <a href = "{{ url('/announcements/beaconIndex/'. $beacon->id) }}"><button type = "button" class = "indexButton">All Announcements</button></a>
    </div>

    <div id = "centerTextContent">
        <p>{!! nl2br($announcement->description) !!}</p>
    </div>
@stop

@section('centerFooter')
    @if($user->type > 1 || $user->id == $beacon->manager)
        <a href="{{ url('/announcements/'.$announcement->id .'/edit')}}"><button type = "button" class = "navButton">Edit</button></a>
    @endif
@stop