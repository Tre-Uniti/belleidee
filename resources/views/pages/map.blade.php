
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
    <div class = ""></div>
        <div id="mapid"></div>

@stop
@section('centerFooter')

@stop
