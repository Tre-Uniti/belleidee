@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
@stop
@section('siteTitle')
    Announcements
@stop

@section('centerText')
    <h2>Announcements for <a href = "{{ url('/beacons'. $beacon->beacon_tag) }})">{{ $beacon->name }}</a></h2>
    <div class = "indexNav">
        <a href = "{{ url('/beacons/'. $beacon->beacon_tag) }}"><button type = "button" class = "indexButton">Beacon Profile</button></a>
    </div>

    <div class = "indexLeft">
        <h4>Title</h4>
    </div>
    <div class = "indexRight">
        <h4>Created At</h4>
    </div>
    @foreach ($announcements as $announcement)
        <div class = "listResource">
            <div class = "indexLeft">
                <a href="{{ action('AnnouncementController@show', [$announcement->id])}}"><button type = "button" class = "interactButtonLeft">{{ $announcement->title }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('AnnouncementController@show', [$announcement->id])}}"><button type = "button" class = "interactButton">{{ $announcement->created_at->format('M-d-Y') }}</button></a>
            </div>
        </div>
    @endforeach
    @include('pagination.custom-paginator', ['paginator' => $announcements])
@stop
@section('centerFooter')
    @if($user->id == $beacon->manager || $user->type > 1)
        <a href = "{{ url('/announcements/create/'. $beacon->id) }}"><button type = "button" class = "navButton">New Announcement</button></a>
    @endif
@stop