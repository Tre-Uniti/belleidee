@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
@stop
@section('siteTitle')
    Most Viewed Beacons
@stop

@section('centerText')
    <h2>{{ $location }} Most Viewed Beacons</h2>
        <div class = "indexNav">
            @if($user->last_tag != null)
                <a href="{{ url('/beacons/'. $user->last_tag)}}" class = "indexLink">{{ $user->last_tag }}</a>
            @endif            <a href="{{ url('/beacons/topTagged')}}" class = "indexLink">Top <i class="fa fa-hashtag" aria-hidden="true"></i></a>
            <a href="{{ url('/beacons')}}" class = "indexLink">Recent</a>
            <a href="{{ url('/beaconRequests')}}" class = "indexLink">Requests</a>
        </div>
        <p>Filter by: <i class="fa fa-eye" aria-hidden="true"></i> (views)</p>
        <hr class = "contentSeparator"/>
        @include('beacons._beaconCards')
@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $beacons])
@stop



