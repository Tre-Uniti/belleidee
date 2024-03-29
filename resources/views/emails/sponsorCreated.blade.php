@extends('emails.base')

@section('emailContent')
    <tr>
        <td colspan = "3"><h3>Greetings, {{$user->handle}}</h3></td>
    </tr>
    <tr>
        <td colspan="3"><b>{{ $sponsor->name }}</b> is now an official Idee Sponsor!</td>
    </tr>
    <tr>
        <td colspan="3">Thank you for submitting this request.</td>
    </tr>
    <tr>
        <td colspan="3"><a href="{{ url('/sponsors/'. $sponsor->id) }}"><button type = "button" style = "padding: 8px 13px;
    font-family: 'Open Sans', Arial, serif;
    font-size: 100%;
    border-radius: 4px;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border: 1px solid #202020;
    color: #FFFFFF;
    background-color: #27AE60">View the Sponsor!</button></a></td>
    </tr>

@endsection
@section('messageType')
    <tr><td>System Message</td></tr>
    <tr><td>Sponsor Created</td></tr>
@stop