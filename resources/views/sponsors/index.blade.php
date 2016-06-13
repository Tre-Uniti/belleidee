@extends('app')
@section('siteTitle')
    Sponsors
@stop

@section('centerText')

    <h2>{{ $location }} Sponsor Directory</h2>
        <p>Sponsor: A business or non-profit promoting within Idee</p>
    <div class = "indexNav">
        <a href={{ url('/sponsors/top')}}><button type = "button" class = "indexButton">Top Sponsors</button></a>
        <a href={{ url('/sponsors/search')}}><button type = "button" class = "indexButton">Search</button></a>
        <a href={{ url('/sponsorRequests')}}><button type = "button" class = "indexButton">Sponsor Requests</button></a>
    </div>
    <div class = "indexLeft">
        <h4>Name</h4>
    </div>
    <div class = "indexRight">
        <h4>Views</h4>
    </div>
    @foreach ($sponsors as $Sponsor)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('SponsorController@show', [$Sponsor->id])}}"><button type = "button" class = "interactButtonLeft">{{ $Sponsor->name }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('SponsorController@show', [$Sponsor->id])}}"><button type = "button" class = "interactButton">{{ $Sponsor->views}}</button></a>
            </div>
        </div>
    @endforeach

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $sponsors])
@stop


