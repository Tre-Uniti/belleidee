@extends('app')
@section('siteTitle')
    Search Users
@stop

@section('centerText')
    <h2>Search Results</h2>
        <div class = "indexNav">
            <a href={{ url('/users/')}}><button type = "button" class = "indexButton">Recent User</button></a>
            <a href={{ url('/users/search')}}><button type = "button" class = "indexButton">User Search</button></a>
            <a href={{ url('/search')}}><button type = "button" class = "indexButton">Global Search</button></a>
        </div>
        <div class = "indexLeft">
            <h4>Handle</h4>
        </div>
        <div class = "indexRight">
            <h4>Joined</h4>
        </div>
    @foreach ($results as $result)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('UserController@show', [$result->id])}}"><button type = "button" class = "interactButtonLeft">{{$result->handle}}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('UserController@show', [$result->id])}}"><button type = "button" class = "interactButton">{{$result->created_at->format('M-d-Y')}}</button></a>
            </div>
        </div>
    @endforeach

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $results->appends(['title' => $handle])])
@stop



