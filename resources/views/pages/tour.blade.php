@extends('auth')
@section('loginTitle')
    Tour
@stop
@section('login')
    <h3>What is Belle-Idee?</h3>
    <ul class = "tour">
        <li>A venue for ideas ,inspirations, and influences</li>
        <li>Integrated with local and global Beacons</li>
        <li>Powered by Laravel & Open Source</li>
        <li>Moderated based on respect and tolerance</li>
        <li>Supported by sponsors with promotions</li>
        <li>Community Questions about ideas & beliefs</li>
        <li>Maintained by <a href = "https://tre-uniti.org" target="_blank" class = "welcomeLink">Tre-Uniti</a></li>
    </ul>
    <a href="{{ url('/auth/register') }}"><button type = "button" class = "navButton">Register</button></a>
    <a href="{{ url('/demo') }}"><button type = "button" class = "navButton">View Demo Page</button></a>
@stop
@section('footer')
    <a href="https://duckduckgo.com/"><button type = "button" class = "interactButton">Not Interested</button></a>
@stop
