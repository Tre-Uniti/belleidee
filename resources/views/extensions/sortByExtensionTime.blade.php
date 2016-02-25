@extends('app')
@section('siteTitle')
    Most Extended
@stop

@section('centerText')
    <div>
        <h2>Most Extended Extensions ({{ $filter }})</h2>
        <table style="display: inline-block;">
            <tr>
                <td><a href={{ url('/extensions/sortByElevationTime/'. $time)}}>Top Elevated</a></td>
                <td><a href={{ url('/extensions/search')}}>Search</a></td>
                <td><a href={{ url('/extensions')}}>Most Recent</a></td>
            </tr>
        </table>
        <div id = "centerTextContent">
            <nav class = "infoNav">
                <ul>
                    <li>
                        <p class = "extras">/-\</p>
                        <div>
                            <table align = "center">
                                <tr>
                                    <td><a href = {{ url('/extensions/extension') }}>Recent</a></td>
                                    @if($time == 'Today')
                                        <td><a href = {{ url('/extensions/extensionTime/Month') }}>Month</a></td>
                                        <td><a href={{ url('/extensions/extensionTime/Year')}}>Year</a></td>
                                        <td><a href={{ url('/extensions/extensionTime/All')}}>All-time</a></td>
                                    @elseif($time == 'Month')
                                        <td><a href={{ url('/extensions/extensionTime/Today')}}>Today</a></td>
                                        <td><a href={{ url('/extensions/extensionTime/Year')}}>Year</a></td>
                                        <td><a href={{ url('/extensions/extensionTime/All')}}>All-time</a></td>
                                    @elseif($time == 'Year')
                                        <td><a href={{ url('/extensions/extensionTime/Today')}}>Today</a></td>
                                        <td><a href = {{ url('/extensions/extensionTime/Month') }}>Month</a></td>
                                        <td><a href={{ url('/extensions/extensionTime/All')}}>All-time</a></td>
                                    @elseif($time == 'All')
                                        <td><a href={{ url('/extensions/extensionTime/Today')}}>Today</a></td>
                                        <td><a href = {{ url('/extensions/extensionTime/Month') }}>Month</a></td>
                                        <td><a href={{ url('/extensions/extensionTime/Year')}}>Year</a></td>
                                    @endif
                                </tr>
                            </table>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <div style = "width: 50%; float: left;">
        <h4>Title</h4>
    </div>
    <div style = "width: 50%; float: right;">
        <h4>User</h4>
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
    {!! $extensions->render() !!}
@stop
