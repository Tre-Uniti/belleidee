@extends('app')
@section('siteTitle')
    Home
@stop
@section('leftSideBar')
        <div>
            <h2>{{$user->handle}}</h2>

            <div class = "innerPhotos">
                <a href="/"><img src={{asset('img/backgroundLandscape.jpg')}} alt="idee" height = "97%" width = "85%"></a>
            </div>
</div>
    @stop
@section('centerText')
    <h1>Home of {{$user->handle}}</h1>
        <a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Elevation: 0</button></a>
        <a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Extension: 0</button></a>
    <hr/>
    <div style = "width: 50%; float: left;">
    <h2>Influenced by</h2>
        </div>
    <div style = "width: 50%; float: right;">
    <h2>Extended by</h2>
        </div>


        <div style = "width: 50%; float: left;">
        <a href="{{ url('/posts')}}"><button type = "button" class = "interactButton">QueenBee</button></a>
            </div>
    <div style = "width: 50%; float: right;">
        <a href="{{ url('/posts')}}"><button type = "button" class = "interactButton">Zoko</button></a>
    </div>
    <div style = "width: 50%; float: left;">
        <a href="{{ url('/posts')}}"><button type = "button" class = "interactButton">Zoko</button></a>
        </div>
    <div style = "width: 50%; float: right;">
        <a href="{{ url('/posts')}}"><button type = "button" class = "interactButton">QueenBee</button></a>
    </div>
    <div style = "width: 50%; float: left;">
        <a href="{{ url('/posts')}}"><button type = "button" class = "interactButton">Amaricus</button></a>
    </div>
    <div style = "width: 50%; float: right;">
        <a href="{{ url('/posts')}}"><button type = "button" class = "interactButton">Leprechaun720</button></a>
    </div>


@stop
@section('centerFooter')
@stop
@section('rightSideBar')
    <h2>Hosted</h2>

    <div class = "innerPhotos">
        <a href="/"><img src={{asset('img/idee.png')}} alt="idee" height = "97%" width = "85%"></a>
    </div>
@stop
