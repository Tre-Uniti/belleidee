@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
@stop
@section('siteTitle')
    Top Sponsored
@stop

@section('centerText')
    <div>
    <h2>{{ $location }} Top Sponsorships</h2>
    <div class = "indexNav">
        <a href={{ url('/sponsors/')}}><button type = "button" class = "indexButton">All Sponsors</button></a>
        <a href={{ url('/sponsors/search')}}><button type = "button" class = "indexButton">Sponsor Search</button></a>
        <a href={{ url('/sponsorRequests')}}><button type = "button" class = "indexButton">Requests</button></a>
    </div>
    <button class = "interactButton" id = "hiddenIndex">More</button>
    <div class = "indexContent" id = "hiddenContent">
        <a href={{ url('/sponsors/joinDate')}}><button type = "button" class = "indexButton">Join Date</button></a>
        <a href={{ url('/sponsors/topViewed')}}><button type = "button" class = "indexButton">Top Viewed</button></a>
    </div>
    </div>
    <div class = "indexLeft">
        <h4>Sponsor</h4>
    </div>
    <div class = "indexRight">
        <h4>Total Sponsorships</h4>
    </div>
    @foreach ($sponsors as $sponsorIndex)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('SponsorController@show', [$sponsorIndex->sponsor_tag])}}"><button type = "button" class = "interactButtonLeft">{{$sponsorIndex->name}}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('SponsorController@show', [$sponsorIndex->sponsor_tag])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{$sponsorIndex->sponsorships}}</button></a>
            </div>
        </div>
    @endforeach
@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $sponsors])
@stop



