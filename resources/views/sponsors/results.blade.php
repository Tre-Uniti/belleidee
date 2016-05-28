@extends('app')
@section('siteTitle')
    Search Sponsors
@stop

@section('centerText')
    <h2>Search Results</h2>
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
        @foreach ($results as $result)
            <div class = "listResource">
                <div class = "listResourceLeft">
                    <a href="{{ action('SponsorController@show', [$result->id])}}"><button type = "button" class = "interactButtonLeft">{{$result->name}}</button></a>
                </div>
                <div class = "listResourceRight">
                    <a href="{{ action('SponsorController@show', [$result->id])}}"><button type = "button" class = "interactButton">{{$result->views}}</button></a>
                </div>
            </div>
        @endforeach

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $results->appends(['identifier' => $identifier])])
@stop



