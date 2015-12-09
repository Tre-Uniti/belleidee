@extends('app')
@section('siteTitle')
    Show Extension
@stop

@include('extensions.leftSide')

@section('centerMenu')
    <h2>{{ $extension->title }}</h2>
    <p>Extension of: <a href = {{ action('PostController@show', [$sources['post_id']])}}> {{ $sources['post_title'] }}</a></p>
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
            <a href="{{ url('/home') }}"><button type = "button" class = "navButton">Elevate</button></a>
            <a href="{{ url('/home') }}"><button type = "button" class = "navButton">Intolerant</button></a>
        @endif
        <a href="{{ url('/home') }}"><button type = "button" class = "navButton">Extend</button></a>

    </div>
@stop

@include('extensions.rightSide')

