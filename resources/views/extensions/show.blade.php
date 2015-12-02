@extends('app')
@section('siteTitle')
    Show Extension
@stop

@include('extensions.leftSide')

@section('centerMenu')
    <h2>{{ $extension->title }}</h2>

@stop

@section('centerText')
    <p style = "margin: 7px">Created on {{ $extension->created_at->format('M-d-Y') }}</p>
    <div>

        <table style="display: inline-block;">
            <thead>
            <tr><th>Belief</th>
            </tr>
            </thead>
            <tbody>
            <tr><td>{{ $extension->index }}</td>
            </tr>
            </tbody>
        </table>

        <table style="display: inline-block;">
            <thead>
            <tr><th>Beacon</th>
            </tr>
            </thead>
            <tbody>
            <tr><td>{{ $extension->belief_beacon }}</td>
            </tr>
            </tbody>
        </table>

        <table style="display: inline-block;">
            <thead>
            <tr><th>Type</th>
            </tr>
            </thead>
            <tbody>
            <tr><td>{{ $extension->index2 }}</td>
            </tr>
            </tbody>
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
            <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Elevate</button></a>
            <a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Intolerant</button></a>
        @endif
        <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Extend</button></a>

    </div>
@stop

@include('extensions.rightSide')

