@extends('app')
@section('siteTitle')
    Top Beacons
@stop

@section('centerText')
    <h2>{{ $location }} Top Beacons</h2>
    <div class = "indexNav">
        <a href={{ url('/beacons/')}}><button type = "button" class = "indexButton">All Beacons</button></a>
        <a href={{ url('/beacons/search')}}><button type = "button" class = "indexButton">Beacon Search</button></a>
        <a href={{ url('/beaconRequests')}}><button type = "button" class = "indexButton">New Requests</button></a>
    </div>
  <hr class = "contentSeparator"/>
    @include('beacons._beaconCards')
@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $beacons])
@stop



