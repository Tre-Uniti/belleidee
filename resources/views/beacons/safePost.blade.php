@extends('app')
@section('siteTitle')
    Beacon Moderators
@stop
@section('centerText')
    <h2><a href={{ url('/beacons/'. $beacon->beacon_tag)}}>{{$beacon->name}}</a></h2>
    <div class = "indexNav">
        <a href="{{ url('/beacons/'. $beacon->beacon_tag)}}" class = "indexLink">Profile</a>
        <a href="{{ url('/beacons/contact/' . $beacon->beacon_tag)}}" class = "indexLink">Contact</a>
        <h4>Safe Post</h4>
            @if($beacon->safePost == false || $beacon->safePost == null)
                <a href = "{{ url('/beacons/enableSafePost/' . $beacon->id) }}" class = "indexLink">On</a>
                <a href = "{{ url('/beacons/disableSafePost/' . $beacon->id) }}" class = "navLink">Off</a>
            @else
                <a href = "{{ url('/beacons/enableSafePost/' . $beacon->id) }}" class = "navLink">On</a>
                <a href = "{{ url('/beacons/disableSafePost/' . $beacon->id) }}" class = "indexLink">Off</a>
            @endif
    </div>
    <hr class = "contentSeparator">
    @include('posts._safePostCards')
@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $posts])
@stop