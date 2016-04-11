@extends('app')
@section('siteTitle')
    Workshops
@stop
@section('centerText')
    <h2>Idee Workshops</h2>
    <p>Here are our upcoming workshops:</p>
    <h4>Coming Soon! </h4>

@stop
@section('centerFooter')
    <a href="{{ url('/tutorials') }}"><button type = "button" class = "navButton">Tutorials</button></a>
    <a href="{{ url('/gettingStarted') }}"><button type = "button" class = "navButton">Getting Started</button></a>
@stop
