@extends('auth')
@section('siteTitle')
    Nymi Auth
@stop

@section('login')
    <h3>Nymi login is under development.</h3>
@stop
@section('footer')
    <p>You may prepare by purchasing a Nymi band: <a href="https://nymi.com/" target = "_blank">here</a></p>
    <p>You can also follow the progress of Web Bluetooth: <a href="https://www.w3.org/community/web-bluetooth/" target = "_blank">here</a></p>

    <p>In the meantime please authenticate using a username/password <a href="{{ url('/auth/login') }}"><button type = "button" class = "navButton">Password Login</button></a></p>
@stop
