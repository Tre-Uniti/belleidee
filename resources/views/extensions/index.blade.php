@extends('app')
@section('siteTitle')
    Extensions
@stop

@section('centerText')
    <div>
        <h2>Recent Extensions</h2>
        <div id = "indexNav">
           <a href={{ url('/extensions/elevation')}}><button type = "button" class = "indexButton">Elevated</button></a>
            <a href={{ url('/extensions/search')}}><button type = "button" class = "indexButton">Search</button></a>
            <a href={{ url('/extensions/extension')}}><button type = "button" class = "indexButton">Extended</button></a>
        </div>

        <nav class = "infoNav">
            <ul>
                <li>
                    <p class = "extras">/-\</p>
                    <div>
                        <div id = "indexNav">
                                <a href={{ url('/extensions/timeFilter/Today')}}><button type = "button" class = "indexButton">Today</button></a>
                                <a href = {{ url('/extensions/timeFilter/Month') }}><button type = "button" class = "indexButton">Month</button></a>
                                <a href={{ url('/extensions/timeFilter/Year')}}><button type = "button" class = "indexButton">Year</button></a>
                                <a href={{ url('/extensions/timeFilter/All')}}><button type = "button" class = "indexButton">All-time</button></a>
                         </div>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
    <div id = "centerTextContent">

    </div>
    <div class = "indexLeft">
        <h4>Title</h4>
    </div>
    <div class = "indexRight">
        <h4>Handle</h4>
    </div>

    @foreach ($extensions as $extension)
        <div class = "listResource">
        <div class = "listResourceLeft">
            <a href="{{ action('ExtensionController@show', [$extension->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $extension->title }}</button></a>
        </div>
        <div class = "listResourceRight">
            <a href="{{ action('UserController@show', [$extension->user_id])}}"><button type = "button" class = "interactButton">{{ $extension->user->handle }}</button></a>
        </div>
        </div>
    @endforeach

@stop

