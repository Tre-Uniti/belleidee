@extends('app')
@section('siteTitle')
    Show Extension
@stop

@include('extensions.leftSide')

@section('centerMenu')
    <h2>{{ $extension->title }}</h2>
    @if($sources['type'] === 'extensions')
        <p>Extension of: <a href = {{ action('ExtensionController@show', [$sources['extenception']])}}> {{ $sources['extension_title'] }}</a></p>
    @elseif($sources['type'] === 'posts')
        <p>Extension of: <a href = {{ action('PostController@show', [$sources['post_id']])}}> {{ $sources['post_title'] }}</a></p>
    @endif
@stop

@section('centerText')
    <div>
        <table style="display: inline-block;">
            <tr>
                <td><a href="{{ url('/posts/') }}">{{ $extension->index }}</a>
                </td>
            </tr>
        </table>

        <table style="display: inline-block;">
            <tr><td><a href="{{ url('/home') }}">{{ $extension->belief_beacon }}</a></td>
            </tr>
        </table>

        <table style="display: inline-block;">
            <tr><td><a href="{{ url('/home') }}">{{ $extension->index2 }}</a></td>
            </tr>
        </table>
    </div>
    <a href={{ url('/extensions/extend/list/'.$extension->id)}}><button type = "button" class = "interactButton">Extensions</button></a>
        <div id = "centerTextContent">
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
                <a href="{{ url('/home') }}"><button type = "button" class = "navButton">Report</button></a>
            @endif
            <a href="{{ url('/extensions/extenception/'. $extension->id) }}"><button type = "button" class = "navButton">Extend</button></a>

    </div>
@stop

@include('extensions.rightSide')

