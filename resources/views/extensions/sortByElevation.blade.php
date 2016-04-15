@extends('app')
@section('siteTitle')
    Top Elevated
@stop

@section('centerText')
        <h2>Elevated Extensions</h2>
        <div class = "indexNav">
            <a href={{ url('/extensions')}}><button type = "button" class = "indexButton">Recent</button></a>
            <a href={{ url('/extensions/search')}}><button type = "button" class = "indexButton">Search</button></a>
            <a href={{ url('/extensions/extension')}}><button type = "button" class = "indexButton">Extended</button></a>
        </div>
        <nav class = "infoNav">
            <ul>
                <li>
                    <p class = "extras">/-\</p>
                    <div class = "indexNav">
                        <a href={{ url('/extensions/elevationTime/Today')}}><button type = "button" class = "indexButton">Today</button></a>
                        <a href = {{ url('/extensions/elevationTime/Month') }}><button type = "button" class = "indexButton">Month</button></a>
                        <a href={{ url('/extensions/elevationTime/Year')}}><button type = "button" class = "indexButton">Year</button></a>
                        <a href={{ url('/extensions/elevationTime/All')}}><button type = "button" class = "indexButton">All-time</button></a>
                    </div>
                </li>
            </ul>
        </nav>
    <div class = "indexLeft">
        <h4>Title</h4>
    </div>
    <div class = "indexRight">
        <h4>Elevation</h4>
    </div>
    @foreach ($elevations as $elevation)
        <div class = "listResource">
        <div class = "listResourceLeft">
            <a href="{{ action('ExtensionController@show', [$elevation->extension_id])}}"><button type = "button" class = "interactButtonLeft">{{ $elevation->extension->title }}</button></a>
        </div>
        <div class = "listResourceRight">
            <a href="{{ action('ExtensionController@listElevation', [$elevation->extension_id])}}"><button type = "button" class = "interactButton">{{ $elevation->extension->elevation }}</button></a>
        </div>
        </div>
    @endforeach

@stop
