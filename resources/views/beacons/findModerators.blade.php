@extends('app')
@section('siteTitle')
    Find Beacon Moderators
@stop
@section('centerText')
    <h2><a href={{ url('/beacons/'. $beacon->beacon_tag)}}>{{$beacon->name}}</a></h2>
    <div class = "indexNav">
        <a href="{{ url('/beacons/'. $beacon->beacon_tag)}}" class = "indexLink">Profile</a>
        <a href="{{ url('/beacons/contact/' . $beacon->beacon_tag)}}" class = "indexLink">Contact</a>
        <p>Searching Moderators for: <a href = "{{ url('/beacons/' . $beacon->beacon_tag) }}" class = "contentHandle">{{ $beacon->beacon_tag }}</a></p>
        <a href = "{{ url('/beacons/moderators/' . $beacon->id) }}" class = "indexLink">Existing Moderators</a>
    </div>
    <hr class = "contentSeparator">
    @include('users._addModCards')
@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $users])
@stop