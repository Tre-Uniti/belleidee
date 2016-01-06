@extends('app')
@section('siteTitle')
    In Development
@stop

@section('centerMenu')
    <h1>This feature is still in development</h1>
    <p>You may track the progress at <a href="http://tre-uniti.org"><button type = "button" class = "navButton">Belle-Creatori</button></a></p>
@stop

@section('rightSideBar')
    <h2>Hosted</h2>

    <div class = "innerPhotos">
        <a href="/"><img src={{asset('img/idee.png')}} alt="idee" height = "97%" width = "85%"></a>
    </div>
@stop