@extends('app')
@section('siteTitle')
    Search Legacy
@stop
@section('centerText')
    <h2>Search Results</h2>
        <div class = "indexNav">
            <a href={{ url('/legacyPosts/')}}><button type = "button" class = "indexButton">Recent Posts</button></a>
               <a href={{ url('/legacyPosts/search')}}><button type = "button" class = "indexButton">Post Search</button></a>
              <a href={{ url('/search')}}><button type = "button" class = "indexButton">Global Search</button></a>
    </div>
        <div class = "indexLeft">
            <h4>Title</h4>
        </div>
        <div class = "indexRight">
            <h4>Belief</h4>
        </div>
        @foreach ($results as $result)
            <div class = "listResource">
                <div class = "listResourceLeft">
                    <a href="{{ action('LegacyPostController@show', [$result->id])}}"><button type = "button" class = "interactButtonLeft">{{$result->title}}</button></a>
                </div>
                <div class = "listResourceRight">
                    <a href="{{ action('BeliefController@show', [$result->belief])}}"><button type = "button" class = "interactButtonLeft">{{$result->belief}}</button></a>
                </div>
            </div>
        @endforeach

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $results->appends(['title' => $title])])
@stop



