@extends('auth')
@section('login')
    <a href="/img/tour.png" target="_blank"><img id = "tourImage" src = "/img/tour.png" alt="tour" width="100%" height="100%"></a>

    <a href="{{ secure_url('/auth/login') }}"><button type = "button" class = "navButton">Login</button></a>
    <a href="{{ secure_url('/auth/register') }}"><button type = "button" class = "navButton">Join</button></a>
@stop
