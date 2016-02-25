@extends('app')
@section('siteTitle')
    Most Extended
@stop

@section('centerText')
    <div>
        <h2>Most Extended Extensions ({{ $filter }})</h2>
        <table style="display: inline-block;">
            <tr>
                <td><a href={{ url('/extensions/elevationTime/'. $time)}}>Top Elevated</a></td>
                <td><a href={{ url('/extensions/search')}}>Search</a></td>
                <td><a href={{ url('/extensions')}}>New Extensions</a></td>
            </tr>
        </table>
        <div id = "centerTextContent">
            <nav class = "infoNav">
                <ul>
                    <li>
                        <a href = {{ url('/extensions/extension') }}><p class = "extras">/Recent\</p></a>
                    </li>
                </ul>
            </nav>
        </div>
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
            <a href="{{ action('ExtensionController@show', [$extension->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $extension->title }}</button></a>
        </div>
        <div class = "listResourceRight">
            <a href="{{ action('ExtensionController@extendList', [$extension->id])}}"><button type = "button" class = "interactButton">{{ $extension->extension }}</button></a>
        </div>
        </div>
    @endforeach

@stop

@section('centerFooter')
    {!! $extensions->render() !!}
@stop
