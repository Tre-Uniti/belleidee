@extends('auth')
@section('loginTitle')
Welcome!
@stop
@section('login')
    <h3>Login Options:</h3>
            <a href="{{ secure_url('/indev') }}"><button type = "button" class = "navButton">Nymi</button></a>
            <a href="{{ secure_url('/auth/login') }}"><button type = "button" class = "navButton">Password</button></a>

        <h3>New members:</h3>
            <a href="{{ secure_url('/tour') }}"><button type = "button" class = "navButton">Take our Tour!</button></a>
            <a href="https://github.com/tre-uniti/belle-idee"><button type = "button" class = "navButton">Adapt our Branch!</button></a>
@stop

@section('footer')
        <!--Question of the Week:-->
            <h2>This week's question:</h2>
                <p>What is an inspiration?</p>
        <!--Question of the Week:-->
@stop
