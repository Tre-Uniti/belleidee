@extends('app')
@section('siteTitle')
    Workshops
@stop
@section('centerText')
    <h2>Workshop Schedule</h2>
    <p>Here are our upcoming workshops</p>


    <h4>Immaculate Heart of Mary @1pm 3/27/16 </h4>

    <p>Please check our online training for digital training</p>
@stop
@section('centerFooter')
    <a href="{{ url('/training') }}"><button type = "button" class = "navButton">Training</button></a>

@stop
