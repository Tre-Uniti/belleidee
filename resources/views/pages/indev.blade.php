@extends('app')
@section('siteTitle')
    In Development
@stop
@section('leftSideBar')
    <div>
        <h2>{{$user->handle}}</h2>

        <div class = "innerPhotos">
            @if($photoPath === '')
                <a href="/"><img src= {{ asset('img/backgroundLandscape.jpg') }} alt="idee" height = "97%" width = "85%"></a>
            @else
                <a href="/"><img src= {{ url('https://s3-us-west-2.amazonaws.com/'. $photoPath) }} alt="{{$user->handle}}" height = "97%" width = "85%"></a>
            @endif
        </div>
    </div>
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