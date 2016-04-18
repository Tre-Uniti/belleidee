@extends('app')
@section('siteTitle')
    Show Beacon
@stop

@section('centerMenu')
    <h2>Support Request</h2>
    <div class = "indexNav">
    <b>Type:</b> {{ $support->type }} <b>Status:</b> {{ $support->status }}
    </div>
@stop

@section('centerText')
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


