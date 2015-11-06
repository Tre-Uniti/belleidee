@extends('emails.base')

@section('emailContent')
    <tr>
        <td colspan="3"><h3>Invitation to Belle-Idee</h3></td>
    </tr>
    <tr>
        <td colspan="3"><h4>Greetings! My name is Zoko and I welcome you to join our community!</h4></td>
    </tr>
    <tr>
        <td colspan="3">One of your friends has invited you to join Belle-Idee.
                A community of fellow beings who respectfully discuss their beliefs.</td>
    </tr>
    <tr>
        <td colspan="3">If interested you may join our beta with the below code:</td>
    </tr>
    <tr>
        <td colspan="3" style="background-color: #FFFFFF">
            {{$invite->betaToken}}
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <a href="{{ url('/tour') }}"><button type = "button" style = "padding: 8px 13px;
    font-family: 'Comic Sans MS', cursive, sans-serif;
    font-size: 100%;
    border-radius: 4px;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border: 1px solid #003300;
    text-shadow: 3px 3px 10px #000000;
    color: #FFFFFF;
    background: linear-gradient(#7dff23, #188BC0);">Check us out!</button></a>
        </td>
    </tr>

@endsection
@section('messageType')
    <tr><td>System Message</td></tr>
    <tr><td>Invitation</td></tr>
@stop