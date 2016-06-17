@extends('app')
@section('siteTitle')
    Top Beacons
@stop

@section('centerText')
    <h2>{{ $location }} Top Sponsors</h2>
        <div class = "indexNav">

          <a href={{ url('/sponsors/')}}><button type = "button" class = "indexButton">All Sponsors</button></a>
             <a href={{ url('/sponsors/search')}}><button type = "button" class = "indexButton">Sponsor Search</button></a>
           <a href={{ url('/search')}}><button type = "button" class = "indexButton">Global Search</button></a>
    </div>
    <div class = "indexLeft">
        <h4>Sponsor</h4>
    </div>
    <div class = "indexRight">
        <h4>Views</h4>
    </div>
    @foreach ($sponsors as $Sponsor)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('SponsorController@show', [$Sponsor->id])}}"><button type = "button" class = "interactButtonLeft">{{$Sponsor->name}}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('SponsorController@sponsorships', [$Sponsor->id])}}"><button type = "button" class = "interactButton">{{$Sponsor->sponsorships}}</button></a>
            </div>
        </div>
    @endforeach

@stop
@section('centerFooter')
    {!! $sponsors->render() !!}
@stop



