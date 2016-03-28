@extends('app')
@section('siteTitle')
    Top Elevated
@stop

@section('centerText')
    <div>
        <h2>Recently Elevated Extensions</h2>
        <table style="display: inline-block;">
            <tr>
                <td><a href={{ url('/extensions')}}>New Extensions</a></td>
                <td><a href={{ url('/extensions/search')}}>Search</a></td>
                <td><a href={{ url('/extensions/extension')}}>Extended</a></td>
            </tr>
        </table>
        <nav class = "infoNav">
            <ul>
                <li>
                    <p class = "extras">/-\</p>
                    <div>
                        <table align = "center">
                            <tr>
                                <td><a href={{ url('/extensions/elevationTime/Today')}}>Today</a></td>
                                <td><a href = {{ url('/extensions/elevationTime/Month') }}>Month</a></td>
                                <td><a href={{ url('/extensions/elevationTime/Year')}}>Year</a></td>
                                <td><a href={{ url('/extensions/elevationTime/All')}}>All-time</a></td>
                            </tr>
                        </table>
                    </div>
            </ul>
        </nav>
    </div>
    <div id = "centerTextContent">

    </div>
    <div style = "width: 50%; float: left;">
        <h4>Title</h4>
    </div>
    <div style = "width: 50%; float: right;">
        <h4>Elevation</h4>
    </div>
    @foreach ($elevations as $elevation)
        <div class = "listResource">
        <div class = "listResourceLeft">
            <a href="{{ action('ExtensionController@show', [$elevation->extension_id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $elevation->extension->title }}</button></a>
        </div>
        <div class = "listResourceRight">
            <a href="{{ action('ExtensionController@listElevation', [$elevation->extension_id])}}"><button type = "button" class = "interactButton">{{ $elevation->extension->elevation }}</button></a>
        </div>
        </div>
    @endforeach

@stop

@section('centerFooter')
@stop
