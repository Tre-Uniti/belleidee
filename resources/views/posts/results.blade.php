@extends('app')
@section('siteTitle')
    Search Posts
@stop


@section('centerText')
    <div>
        <h2>Search Results</h2>

        <div style = "width: 50%; float: left;">
            <h4>Title</h4>
        </div>
        <div style = "width: 50%; float: right;">
            <h4>User</h4>
        </div>
        @foreach ($results as $result)
            <div class = "listResource">
                <div class = "listResourceLeft">
                    <a href="{{ action('PostController@show', [$result['id']])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{$result['title']}}</button></a>
                </div>
                <div class = "listResourceLeft">
                    <a href="{{ action('UserController@show', [$result['user_id']])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{$result['belief']}}</button></a>
                </div>
            </div>
        @endforeach
   
    </div>
@stop
@section('centerFooter')
            <a href="{{ url('/posts/topElevated') }}"><button type = "button" class = "navButton">Top Elevated</button></a>
            <a href="{{ url('/posts') }}"><button type = "button" class = "navButton">Recent Posts</button></a>
            <a href="{{ url('/posts/mostExtended') }}"><button type = "button" class = "navButton">Most Extended</button></a>
@stop



