
@extends('app')
@section('pageHeader')
    <link rel="stylesheet" href="/css/leaflet.css" />
    <script src="/js/leaflet.js"></script>
    <script src="/js/map.js"></script>
@stop
@section('siteTitle')
    Idee Map
@stop
@section('centerText')
    <h2>Idee Map:</h2>
    <p>Your location: {{ $location }}</p>
    <div class = ""></div>
        <div id="mapid"></div>

@stop
@section('centerFooter')
    <a href="{{ URL::previous() }}"><button type = "button" id = "cancel" class = "navButton">Back</button></a>
@stop
