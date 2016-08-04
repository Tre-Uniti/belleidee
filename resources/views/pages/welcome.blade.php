@extends('auth')
@section('login')
    <p>A community sharing ideas and inspirations.</p>
    <a href="{{ secure_url('/auth/login') }}"><button type = "button" class = "navButton">Login</button></a>
    <a href="{{ secure_url('/tour') }}"><button type = "button" class = "navButton">Take our Tour</button></a>
    <a href="https://github.com/tre-uniti/belle-idee" target = "_blank"><button type = "button" class = "navButton" >Open Source</button></a>
@stop
