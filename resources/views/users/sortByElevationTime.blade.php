@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
@stop
@section('siteTitle')
    Elevated Users
@stop

@section('centerText')
    <div>
    <h2>Top Elevated Users ({{ $filter }})</h2>
        <div class = "indexNav">
            <a href={{ url('/users')}}><button type = "button" class = "indexButton">New Users</button></a>
            <a href={{ url('/users/search')}}><button type = "button" class = "indexButton">Search</button></a>
            <a href={{ url('/users/extensionTime/'. $time)}}><button type = "button" class = "indexButton">Extended</button></a>
        <nav class = "infoNav">
            <ul>
                <li>
                    <a href = {{ url('/users/elevation') }}><button type = "button" class = "indexButton">Recently Elevated</button></a>
                </li>
            </ul>
        </nav>
    </div>
    </div>
    <div class = "indexLeft">
        <h4>Title</h4>
    </div>
    <div class = "indexRight">
        <h4>Elevation</h4>
    </div>
        @foreach ($users as $User)
            <div class = "listResource">
            <div class = "listResourceLeft">
            <a href="{{ action('UserController@show', [$User->id])}}"><button type = "button" class = "interactButtonLeft">{{ $User->handle }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('UserController@elevatedBy', [$User->id])}}"><button type = "button" class = "interactButton">{{ $User->elevation }}</button></a>
            </div>
            </div>
        @endforeach
@stop
@section('centerFooter')
    {!! $users->render() !!}
@stop



