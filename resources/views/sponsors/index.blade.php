@extends('app')
@section('pageHeader')
    <script src = '/js/index.js'></script>
@stop
@section('siteTitle')
    Sponsors
@stop

@section('centerText')
    <div>
    <h2>{{ $location }} Sponsor Directory</h2>
        <p>Sponsor: A business or non-profit promoting within Belle-idee</p>
    <div class = "indexNav">
        <a href={{ url('/promotions')}}><button type = "button" class = "indexButton">Promotions</button></a>
        <a href={{ url('/sponsors/search')}}><button type = "button" class = "indexButton">Search</button></a>
        <a href={{ url('/sponsorRequests')}}><button type = "button" class = "indexButton">Requests</button></a>
    </div>
        <button class = "interactButton" id = "hiddenIndex">More</button>
    <div class = "indexContent" id = "hiddenContent">
        <a href={{ url('/sponsors/joinDate')}}><button type = "button" class = "indexButton">Join Date</button></a>
        <a href={{ url('/sponsors/topSponsored')}}><button type = "button" class = "indexButton">Top Sponsored</button></a>
        <a href={{ url('/sponsors/topViewed')}}><button type = "button" class = "indexButton">Top Viewed</button></a>
    </div>
    </div>
    <div class = "indexLeft">
        <h4>Name</h4>
    </div>
    <div class = "indexRight">
        <h4>Tag</h4>
    </div>
    @foreach ($sponsors as $Sponsor)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('SponsorController@show', [$Sponsor->sponsor_tag])}}"><button type = "button" class = "interactButtonLeft">{{ $Sponsor->name }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('SponsorController@show', [$Sponsor->sponsor_tag])}}"><button type = "button" class = "interactButton">{{ $Sponsor->sponsor_tag}}</button></a>
            </div>
        </div>
    @endforeach

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $sponsors])
@stop


