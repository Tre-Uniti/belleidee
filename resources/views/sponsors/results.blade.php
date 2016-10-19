@extends('app')
@section('siteTitle')
    Search Sponsors
@stop

@section('centerText')
    <h2>Search Results</h2>
    <div class = "indexNav">
        <a href={{ url('/sponsors/')}}><button type = "button" class = "indexButton">All Sponsors</button></a>
        <a href="{{ url('/results?identifier=' . $identifier) }}" class = "indexLink">Expand Search</a>
        <a href="{{ url('/sponsorRequests/create') }}"><button type = "button" class = "indexButton">Request New Sponsor</button></a>
    </div>

    <div class = "contentHeaderSeparator">
        <h3>Search Results ( {{ $sponsorCount}}@if($sponsorCount == 10)+  @endif ) </h3>
    </div>
    @include('sponsors._sponsorCards')


@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $sponsors->appends(['identifier' => $identifier])])
@stop



