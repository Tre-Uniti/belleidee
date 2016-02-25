@extends('app')
@section('siteTitle')
    Most Extended
@stop



@section('centerText')
    <div>
        <h2>Recently Extended Extensions</h2>
        <table style="display: inline-block;">
            <tr>
                <td><a href={{ url('/extensions/elevation')}}>Top Elevated</a></td>
                <td><a href={{ url('/extensions/search')}}>Search</a></td>
                <td><a href={{ url('/extensions')}}>New Extensions</a></td>
            </tr>
        </table>
    </div>
    <div id = "centerTextContent">
        <nav class = "infoNav">
            <ul>
                <li>
                    <p class = "extras">/-\</p>
                    <div>
                        <table align = "center">
                            <tr>
                                <td><a href={{ url('/extensions/extensionTime/Today')}}>Today</a></td>
                                <td><a href = {{ url('/extensions/extensionTime/Month') }}>Month</a></td>
                                <td><a href={{ url('/extensions/extensionTime/Year')}}>Year</a></td>
                                <td><a href={{ url('/extensions/extensionTime/All')}}>All-time</a></td>
                            </tr>
                        </table>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
    <div style = "width: 50%; float: left;">
        <h4>Title</h4>
    </div>
    <div style = "width: 50%; float: right;">
        <h4>Extensions</h4>
    </div>

    @foreach ($extensions as $extension)

        <div class = "listResource">
        <div class = "listResourceLeft">
            <a href="{{ action('ExtensionController@show', [$extension->extenception])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $extension->extenceptionTitle($extension->extenception) }}</button></a>
        </div>
        <div class = "listResourceRight">
            <a href="{{ action('ExtensionController@extendList', [$extension->extenception])}}"><button type = "button" class = "interactButton">{{ $extension->extenceptionExtension($extension->extenception) }}</button></a>
        </div>
        </div>
    @endforeach
@stop

@section('centerFooter')
@stop
