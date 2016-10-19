@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
@stop
@section('siteTitle')
    Sponsors by Join Date
@stop

@section('centerText')
    <div>
        <h2>{{ $location }} Sponsors by Join Date</h2>
        <div class = "indexNav">
            <a href={{ url('/sponsors/')}}><button type = "button" class = "indexButton">All Sponsors</button></a>
            <a href={{ url('/sponsors/search')}}><button type = "button" class = "indexButton">Sponsor Search</button></a>
            <a href={{ url('/sponsorRequests')}}><button type = "button" class = "indexButton">Requests</button></a>
        </div>
        <button class = "interactButton" id = "hiddenIndex">More</button>
        <div class = "indexContent" id = "hiddenContent">
            <a href={{ url('/sponsors/topSponsored')}}><button type = "button" class = "indexButton">Top Sponsored</button></a>
            <a href={{ url('/sponsors/topViewed')}}><button type = "button" class = "indexButton">Top Viewed</button></a>
        </div>
    </div>

    <hr class = "contentSeparator"/>
    @include('sponsors._sponsorCards')
@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $sponsors])
@stop



