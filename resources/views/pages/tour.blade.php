@extends('auth')
@section('loginTitle')
    Tour
@stop
@section('login')
    <h3>What is Belle-Idee?</h3>
    <ul style = "color: white; text-align: left;">
        <li>A community of belief journeyers</li>
        <li>Integrated with localized Beacons</li>
        <li>Supported by sponsors with promotions</li>
        <li>Powered by Laravel & Open Source</li>
        <li>Moderated based on respect and tolerance</li>
        <li>Community Question revolving around beliefs.</li>
        <li>Maintained by Tre-Uniti LLC</li>
    </ul>
    <a href="{{ url('/demo') }}"><button type = "button" class = "navButton">View Demo Page</button></a>
@stop
@section('footer')
    <a href="https://duckduckgo.com/"><button type = "button" class = "interactButton">Not Interested</button></a>
@stop
