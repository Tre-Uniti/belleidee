@extends('app')
@section('siteTitle')
    Extensions
@stop

@section('centerText')
    <div>
        <h2>Recent Extensions</h2>
        <table style="display: inline-block;">
            <tr>
                <td><a href={{ url('/extensions/elevation')}}>Elevated</a></td>
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
                                <td><a href={{ url('/extensions/timeFilter/Today')}}>Today</a></td>
                                <td><a href = {{ url('/extensions/timeFilter/Month') }}>Month</a></td>
                                <td><a href={{ url('/extensions/timeFilter/Year')}}>Year</a></td>
                                <td><a href={{ url('/extensions/timeFilter/All')}}>All-time</a></td>
                            </tr>
                        </table>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
    <div id = "centerTextContent">

    </div>
    <div style = "width: 50%; float: left;">
        <h4>Title</h4>
    </div>
    <div style = "width: 50%; float: right;">
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

@section('centerFooter')
@stop
