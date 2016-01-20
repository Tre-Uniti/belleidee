@extends('app')
@section('siteTitle')
    Show Extension
@stop


@section('centerMenu')
    <h2>{{ $extension->title }}</h2>

@stop

@section('centerText')
    <div>
        <div>
            <table align = "center">
                <tr>
                    <td><a href="{{ action('BeliefController@beliefIndex', $extension->belief) }}">{{ $extension->belief }}</a></td>
                    <td><a href="{{ url('/beacons/tags/'.$extension->beacon_tag) }}">{{ $extension->beacon_tag }}</a></td>
                    <td><a href="{{ url('/extensions') }}">{{ $extension->category }}</a></td>
                </tr>
            </table>
        </div>
    </div>
        <div id = "centerTextContent">
            <nav class = "infoNav">
                <ul>
                    <li>
                        <p class = "extras">/-\</p>
                        <div>
                            @if($sources['type'] === 'extensions')
                                <p>Extends: <a href = {{ action('ExtensionController@show', [$sources['extenception']])}}> {{ $sources['extension_title'] }}</a></p>
                            @elseif($sources['type'] === 'posts')
                                <p>Extends: <a href = {{ action('PostController@show', [$sources['post_id']])}}> {{ $sources['post_title'] }}</a></p>
                            @endif
                            <table align = "center">
                                <tr>
                                    <td><a href={{ url('/indev')}}>Elevation</a></td>
                                    <td> <a href = {{ url('/posts/date/'.$extension->created_at->format('M-d-Y')) }}>{{ $extension->created_at->format('M-d-Y') }}</a></td>
                                    <td><a href={{ url('/extensions/extend/list/'.$extension->id)}}>Extension</a></td>
                                </tr>
                            </table>

                        </div>
                    </li>
                </ul>
            </nav>
            <p>
                {!! nl2br(e($extension->body)) !!}
            </p>

        </div>
@stop

@section('centerFooter')
    <div id = "centerFooter">
        @if($extension->user_id == Auth::id())
            <a href="{{ url('/extensions/'.$extension->id.'/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
        @else
            @if($elevation === 'Elevated')
                <a href="{{ url('/extensions/'.$extension->id) }}"><button type = "button" class = "navButton">{{ $elevation }}</button></a>
            @else
                <a href="{{ url('/extensions/elevate/'.$extension->id) }}"><button type = "button" class = "navButton">{{ $elevation }}</button></a>
            @endif
                <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Report</button></a>
            @endif
            <a href="{{ url('/extensions/extenception/'. $extension->id) }}"><button type = "button" class = "navButton">Extend</button></a>

    </div>
@stop

@include('extensions.rightSide')

