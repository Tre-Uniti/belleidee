@extends('auth')
@section('siteTitle')
    Welcome to Belle-idee
@stop

@section('centerContent')
    <div class = "contentCard">
        <a href="/img/tour.png" target="_blank"><img id = "tourImage" src = "/img/tour.png" alt="tour" width="100%" height="100%"></a>
    </div>

@stop
@section('footer')
    @if(isset($user))
        <a href="{{ secure_url('/about') }}" class = "navLink">About</a>
    @else
        <a href="{{ secure_url('/auth/login') }}" class = "navLink">Login</a>
        <a href="{{ secure_url('/about') }}" class = "navLink">About</a>
        <a href="{{ secure_url('/auth/register') }}" class = "navLink">Join</a>
    @endif
@stop
