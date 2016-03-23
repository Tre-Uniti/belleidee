@extends('emails.base')

@section('emailContent')
    <tr>
        <td colspan = "3"><h3>Greetings, {{$user->handle}}</h3></td>
    </tr>
    <tr>
        <td colspan="3"><b>{{ $beacon->name }}</b> is now an official Idee Beacon!</td>
    </tr>
    <tr>
        <td colspan="3">Thank you for submitting this request.</td>
    </tr>
    <tr>
        <td colspan="3"><a href="{{ url('/beacons/'. $beacon->id) }}"><button type = "button" style = "padding: 8px 13px;
    font-family: 'Open Sans', Arial, serif;
    font-size: 100%;
    border-radius: 4px;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border: 1px solid #003300;
    text-shadow: 3px 3px 10px #000000;
    color: #FFFFFF;
    background: linear-gradient(#7dff23, #188BC0);
    background: -webkit-linear-gradient(#7dff23, #188BC0);
    background: -o-linear-gradient(#7dff23, #188BC0);
    background: -moz-linear-gradient(#7dff23, #188BC0);
  ">View the Beacon!</button></a></td>
    </tr>

@endsection
@section('messageType')
    <tr><td>System Message</td></tr>
    <tr><td>Beacon Created</td></tr>
@stop