@extends('app')
@section('siteTitle')
    Demo
@stop
@section('handle')
    (User Handle)
@stop
@section('centerText')
    <h1>Idee Demo Page</h1>
    <h2>Layout:</h2>
    <p>Main content appears in the center and when hovered or tapped will hide side nav and content </p>

    <h2>Operations</h2>
    <p>1 primary post every 24 hours, 1 weekly answer, and 1 active sponsor per user</p>

    <h2>Beacons</h2>
    <p>Beacon centers are places of worship or venues for thought</p>

    <a href="{{ url('/auth/register') }}"><button type = "button" class = "navButton">I'd like to join!</button></a>
@stop
@section('centerFooter')
    <a href="https://duckduckgo.com/"><button type = "button" class = "interactButton">Not Interested</button></a>
@stop
