@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
@stop
@section('siteTitle')
    Extended Users
@stop
@section('centerText')
    <div>
    <h2>Most Extended Users ({{$filter}})</h2>
    <div class = "indexNav">
        <a href={{ url('/users/elevationTime/'. $time)}}><button type = "button" class = "indexButton">Elevated</button></a>
        <a href={{ url('/users/search')}}><button type = "button" class = "indexButton">Search</button></a>
        <a href={{ url('/users')}}><button type = "button" class = "indexButton">New Users</button></a>
        </div>
        <button class = "interactButton" id = "hiddenIndex">More</button>
        <div class = "indexContent" id = "hiddenContent">
            <a href={{ url('/users/extensionTime/Today')}}><button type = "button" class = "indexButton">Today</button></a>
            <a href = {{ url('/users/extensionTime/Month') }}><button type = "button" class = "indexButton">Month</button></a>
            <a href={{ url('/users/extensionTime/Year')}}><button type = "button" class = "indexButton">Year</button></a>
            <a href={{ url('/users/extensionTime/All')}}><button type = "button" class = "indexButton">All-time</button></a>
        </div>
    </div>

    <div class = "indexLeft">
        <h4>Title</h4>
    </div>
    <div class = "indexRight">
        <h4>Extensions</h4>
    </div>
        @foreach ($users as $User)
            <div class = "listResource">
            <div class = "listResourceLeft">
            <a href="{{ action('UserController@show', [$User->id])}}"><button type = "button" class = "interactButtonLeft">{{ $User->handle }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('UserController@extendedBy', [$User->id])}}"><button type = "button" class = "interactButton">{{ $User->extension }}</button></a>
            </div>
            </div>
        @endforeach
@stop
@section('centerFooter')
    {!! $users->render() !!}
@stop



