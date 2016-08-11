@extends('emails.base')

@section('emailContent')
    <tr>
        <td colspan="3"><h3>Invitation to Belle-Idee</h3></td>
    </tr>
    <tr>
        <td colspan="3">Greetings!</td>
    </tr>
    <tr>
        <td colspan="3">One of your friends has invited you to join Belle-Idee.</td>
    </tr>
    <tr>
        <td colspan="3">Belle-Idee is a community who respectfully discuss our ideas and beliefs</td>
    </tr>

    <tr>
        <td colspan="3">
            <a href="{{ url('/tour') }}"><button type = "button" style = "padding: 8px 13px;
    font-family: 'Open Sans', Arial, serif;
    font-size: 100%;
    border-radius: 4px;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border: 1px solid #202020;
    color: #FFFFFF;
    background-color: #27AE60
  ">Check us out!</button></a>
        </td>
    </tr>

@endsection
@section('messageType')
    <tr><td>System Message</td></tr>
    <tr><td>Invitation</td></tr>
@stop