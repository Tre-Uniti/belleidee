@extends('app')
@section('siteTitle')
    Show Beacon
@stop

@section('centerText')
    <h2>{{ $support->subject }}</h2>
    <p>(This {{ $support->type }} ticket is {{ $support->status }})</p>
    <div id = "centerTextContent">
        <p>
            {{ $support->request }}
        </p>
    </div>
@stop

@section('centerFooter')
    <a href="{{ url('supports/') }}"><button type = "button" class = "navButton">Other Requests</button></a>
    <a href="{{ url('supports/'. $support->id . '/edit') }}"><button type = "button" class = "navButton">Edit</button></a>

@stop


