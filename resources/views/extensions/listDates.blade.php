@extends('app')
@section('siteTitle')
    Extensions by Date
@stop

@section('centerText')
    <h2>Extensions Created on {{ $date->format('M-d-Y') }}</h2>
    <div id = "indexNav">
        <a href="{{ url('/extensions/forYou')}}" class = "indexLink">For You</a>
        <a href="{{ url('/beacons/extensions/'. $user->last_tag)}}" class = "indexLink">{{ $user->last_tag }}</a>
        <a href="{{ url('extensions/elevationTime/Month')}}" class = "indexLink">Top <i class="fa fa-heart" aria-hidden="true"></i></a>
        <a href="{{ url('extensions/extensionTime/Month')}}" class = "indexLink">Most <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i></a>
    </div>
    <hr class = "contentSeparator">
    @include('extensions._extensionCards')
@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $extensions])
@stop


