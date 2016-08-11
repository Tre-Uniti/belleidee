@extends('emails.base')

@section('emailContent')
    <tr>
        <td colspan = "3"><h3>Thank you {{$user->handle}} for signing up!</h3></td>
    </tr>
    <tr>
        <td colspan="3"><a href="{{ url("auth/confirm/{$user->emailToken}") }}"><button type = "button" style = "padding: 8px 13px;
    font-family: 'Open Sans', Arial, serif;
    font-size: 100%;
    border-radius: 4px;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border: 1px solid #202020;
    color: #FFFFFF;
    background-color: #27AE60">Confirm and Login</button></a></td>
    </tr>
    <tr>
        <td colspan = "3">
            <p>We look forward to your participation in this community.</p>
        </td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: left;">What do these terms mean?</td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: left;">1.  <b>Elevation</b> is similar to "Like" and <b>Extension</b> is similar to "Comment".</td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: left;">2.  <b>Beacons</b> are places of worship or thought like Libraries, Churches, Mosques, etc.</td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: left;">3.  <b>Sponsors</b> are chosen by each user to sponsor them and receive promotions.</td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: left;">*  By confirming you agree to our <a href="{{ url("/privacy") }}" style = "color: black;">Privacy Policy</a> and <a href="{{ url("/terms") }}" style = "color: black;">Terms of Use</a>. *</td>
    </tr>

@endsection
@section('messageType')
    <tr><td>System Message</td></tr>
    <tr><td>Verification</td></tr>
@stop