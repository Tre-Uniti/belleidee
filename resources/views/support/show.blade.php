@extends('app')
@section('siteTitle')
    Show Beacon
@stop



@section('centerMenu')
    <h2>Support Request: #{{ $support->id }}</h2>
@stop

@section('centerText')
    <div id = "centerTextContent">
        <p>
            {{ $support->request }}
        </p>
    </div>
@stop

@section('centerFooter')

@stop


