@extends('auth')
@section('loginTitle')
    Tour
@stop
@section('login')
    <h3>Belle-Idee Privacy Policy</h3>
    <ul style = "color: white; text-align: left;">
        <li>A community of idea & belief journeyers</li>
        <li>Integrated with localized Beacons</li>
        <li>Powered by Laravel & Open Source</li>
        <li>Moderated based on respect and tolerance</li>
        <li>Supported by sponsors with promotions</li>
        <li>Community Questions about ideas & beliefs</li>
        <li>Maintained by Tre-Uniti LLC</li>
    </ul>
    <a href="{{ url('/demo') }}"><button type = "button" class = "navButton">Contact Us</button></a>
@stop
@section('footer')

@stop