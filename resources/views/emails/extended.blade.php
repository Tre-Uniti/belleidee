@extends('emails.base')

@section('emailContent')
    <tr>
        <td colspan = "3"><h3>Greetings, {{$user->handle}}</h3></td>
    </tr>
    <tr>
        <td colspan="3">Your post has been extended!</td>
    </tr>
    <tr>
        <td colspan="3">
             <a href="{{ url("extensions/{$extension->id}") }}"><button type = "button" style = "padding: 8px 13px;
    font-family: 'Open Sans', Arial, serif;
    font-size: 100%;
    border-radius: 4px;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border: 1px solid #202020;
    color: #FFFFFF;
    background-color: #27AE60">View the extension</button></a>
        </td>
    </tr>
    <tr>
        <td colspan="3">Extended by: {{ $extension->user->handle }}</td>
    </tr>
    <tr>
        <td colspan="3">{{ $extension->belief }} - {{ $extension->beacon_tag }} - {{ $extension->source }} </td>
    </tr>

@endsection
@section('messageType')
    <tr><td>System Message</td></tr>
    <tr><td>Notification</td></tr>
@stop