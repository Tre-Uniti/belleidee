@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
@stop
@section('siteTitle')
    Users
@stop

@section('centerText')
    <div>
    <h2>User Directory</h2>
        <div class = "indexNav">
            <a href={{ url('/users/sortByElevation')}}><button type = "button" class = "indexButton">Top Elevated</button></a>
            <a href={{ url('/users/search')}}><button type = "button" class = "indexButton">Search</button></a>
            <a href={{ url('/users/sortByExtension')}}><button type = "button" class = "indexButton">Most Extended</button></a>
        </div>
    <button class = "interactButton" id = "hiddenIndex">More</button>
    <div class = "indexContent" id = "hiddenContent">
        <a href={{ url('/users/timeFilter/Today')}}><button type = "button" class = "indexButton">Today</button></a>
        <a href={{ url('/users/timeFilter/Month') }}><button type = "button" class = "indexButton">Month</button></a>
        <a href={{ url('/users/timeFilter/Year')}}><button type = "button" class = "indexButton">Year</button></a>
        <a href={{ url('/users/timeFilter/All')}}><button type = "button" class = "indexButton">All-time</button></a>
    </div>
        </div>
    <div class = "indexLeft">
        <h4>Handle</h4>
    </div>
    <div class = "indexRight">
        <h4>Joined</h4>
    </div>
    @foreach ($users as $user2)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('UserController@show', [$user2->id])}}"><button type = "button" class = "interactButton">{{ $user2->handle }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('UserController@show', [$user2->id])}}"><button type = "button" class = "interactButton">{{ $user2->created_at->format('M-d-Y') }}</button></a>
            </div>
        </div>
    @endforeach
@stop
@section('centerFooter')

@stop


