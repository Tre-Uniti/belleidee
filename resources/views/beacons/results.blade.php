@extends('app')
@section('siteTitle')
    Search Beacons
@stop

@section('centerText')
        <h2>{{ $location }} Beacon Directory</h2>
        <div class = "indexNav">
            <a href={{ url('/beacons/')}}><button type = "button" class = "indexButton">All Beacons</button></a>
            <a href="{{ url('/results?identifier=' . $identifier) }}" class = "indexLink">Expand Search</a>
            <a href="{{ url('/beaconRequests/create') }}"><button type = "button" class = "indexButton">Request New Beacon</button></a>
        </div>

        <div class = "contentHeaderSeparator">
            <h3>Search Results ( {{ $beaconCount}}@if($beaconCount == 10)+  @endif ) </h3>
        </div>
            @include('beacons._beaconCards')
@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $beacons->appends(['identifier' => $identifier])])
@stop



