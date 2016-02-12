@extends('app')
@section('siteTitle')
    Search Posts
@stop


@section('centerText')
    <div>
        <h2>Search Results</h2>

        {{ $results["took"] }}
   
    </div>
@stop
@section('centerFooter')
            <a href="{{ url('/posts/topElevated') }}"><button type = "button" class = "navButton">Top Elevated</button></a>
            <a href="{{ url('/posts') }}"><button type = "button" class = "navButton">Recent Posts</button></a>
            <a href="{{ url('/posts/mostExtended') }}"><button type = "button" class = "navButton">Most Extended</button></a>
@stop



