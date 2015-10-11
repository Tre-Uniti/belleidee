@extends('login')
@section('siteTitle')
    Welcome!
@stop
@section('login')
        <h3>Login Options:</h3>
            <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Nymi</button></a>
            <a href="{{ url('/auth/login') }}"><button type = "button" class = "interactButton">Password</button></a>

        <h3>New members:</h3>
            <a href="{{ url('/auth/register') }}"><button type = "button" class = "interactButton">Take our Tour!</button></a>
            <a href="https://bella.ninja"><button type = "button" class = "interactButton">Adapt our Clone!</button></a>
@stop

@section('footer')
        <!--Question of the Week:-->
            <h2>This week's question:</h2>
                <p>How are we influenced by our emotions, what purpose do they play?</p>
        <!--Question of the Week:-->
@stop
