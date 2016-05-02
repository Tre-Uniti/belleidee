@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
@stop
@section('siteTitle')
    Most Extended
@stop
@section('centerText')
    <div>
    <h2>Extended Extensions</h2>
        <div class = "indexNav">

            <a href={{ url('/extensions/elevation')}}><button type = "button" class = "indexButton">Elevated</button></a>
            <a href={{ url('/extensions/search')}}><button type = "button" class = "indexButton">Search</button></a>
            <a href={{ url('/extensions')}}><button type = "button" class = "indexButton">Recent</button></a>
        </div>
    <button class = "interactButton" id = "hiddenIndex">More</button>
    <div class = "indexContent" id = "hiddenContent">
        <a href={{ url('/extensions/extensionTime/Today')}}><button type = "button" class = "indexButton">Today</button></a>
        <a href = {{ url('/extensions/extensionTime/Month') }}><button type = "button" class = "indexButton">Month</button></a>
        <a href={{ url('/extensions/extensionTime/Year')}}><button type = "button" class = "indexButton">Year</button></a>
        <a href={{ url('/extensions/extensionTime/All')}}><button type = "button" class = "indexButton">All-time</button></a>
    </div>
    </div>
    <div class = "indexLeft">
        <h4>Title</h4>
    </div>
    <div class = "indexRight">
        <h4>Extensions</h4>
    </div>

    @foreach ($extensions as $extension)

        <div class = "listResource">
        <div class = "listResourceLeft">
            <a href="{{ action('ExtensionController@show', [$extension->extenception])}}"><button type = "button" class = "interactButtonLeft">{{ $extension->extenceptionTitle($extension->extenception) }}</button></a>
        </div>
        <div class = "listResourceRight">
            <a href="{{ action('ExtensionController@extendList', [$extension->extenception])}}"><button type = "button" class = "interactButton">{{ $extension->extenceptionExtension($extension->extenception) }}</button></a>
        </div>
        </div>
    @endforeach
@stop

