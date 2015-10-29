@extends('app')
@section('siteTitle')
    In Development
@stop
@section('handle')
    {{Auth::user()->handle}}
@stop
@section('centerMenu')
    <h1>This feature is still in development</h1>

@stop
@section('centerFooter')
    <p>You may track the dev progress at <a href="https://bella.ninja"><button type = "button" class = "navButton">Bella Ninja</button></a></p>
@stop