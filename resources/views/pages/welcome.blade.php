@extends('auth')
@section('loginTitle')
    Welcome!
@stop
@section('login')
    <meta name="google-site-verification" content="yJFOL4PAS5gZ5D2HbR0K9ESGx8ser7t_QW7sd8_wjrU" />
    <h3>Login Options:</h3>
            <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "navButton">Nymi</button></a>
            <a href="{{ url('/auth/login') }}"><button type = "button" class = "navButton">Password</button></a>

        <h3>New members:</h3>
            <a href="{{ url('/auth/register') }}"><button type = "button" class = "navButton">Take our Tour!</button></a>
            <a href="https://bella.ninja"><button type = "button" class = "navButton">Adapt our Branch!</button></a>
@stop

@section('footer')
        <!--Question of the Week:-->
            <h2>This week's question:</h2>
                <p>How are we influenced by our emotions, what purpose do they play?</p>
        <!--Question of the Week:-->
@stop
