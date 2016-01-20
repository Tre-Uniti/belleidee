@extends('emails.base')

@section('emailContent')
    <tr>
        <td colspan="3"><h3>Invitation to Belle-Idee</h3></td>
    </tr>
    <tr>
        <td colspan="3">Greetings! This is a message from Tre-Uniti and we welcome you to join our community!</td>
    </tr>
    <tr>
        <td colspan="3">One of your friends has invited you to join Belle-Idee.</td>
    </tr>
    <tr>
        <td colspan="3">Belle-Idee is a community who respectfully discuss their beliefs</td>
    </tr>
    <tr>
        <td colspan="3">-</td>
    </tr>
    <tr>
        <td colspan="3">You may register with the beta token below:</td>
    </tr>
    <tr>
        <td colspan="3" style="background-color: #E0E0E0">
            {{$invite->betaToken}}
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <a href="{{ url('/tour') }}"><button type = "button" style = "padding: 8px 13px;
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
  ">Check us out!</button></a>
        </td>
    </tr>

@endsection
@section('messageType')
    <tr><td>System Message</td></tr>
    <tr><td>Invitation</td></tr>
@stop