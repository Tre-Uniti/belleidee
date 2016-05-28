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
        <nav class = "infoNav">
            <ul>
                <li>
                    <a href = {{ url('/users/extension') }}><button type = "button" class = "indexButton">Recently Extended</button></a>
                </li>
            </ul>
        </nav>
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
    @include('pagination.custom-paginator', ['paginator' => $users])
@stop



