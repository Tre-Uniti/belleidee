@extends('emails.base')

@section('emailContent')
    <tr>
        <td colspan = "3"><h3>Thank you {{$user->handle}} for signing up!</h3></td>
    </tr>
    <tr>
        <td colspan="3">Please click on the button to <a href="{{ url("auth/confirm/{$user->emailToken}") }}"><button type = "button" style = "padding: 8px 13px;
    font-family: 'Comic Sans MS', cursive, sans-serif;
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
    background: -moz-linear-gradient(#7dff23, #188BC0);">Login</button></a></td>
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
        <td colspan="3" style = "text-align: left;">1.  <b>Tre-Uniti</b> is the handle of the CEO of Tre-Uniti, the posts from Tre-Uniti are meant to help users understand the site.</td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: left;">2.  <b>Elevation</b> is similar to "Like" and <b>Extension</b> is similar to "Comment".</td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: left;">3.  <b>Beacons</b> are places of worship like Churches, Synagogues, Mosques, and Temples.</td>
    </tr>
    <tr>
        <td>
            <hr/>
        </td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: left;">How do I get started once I login?</td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: left;">1.  You may get started by exploring, elevating and extending the user posts especially Tre-Uniti's.</td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: left;">2.  Choose a sponsor from the Idee directory to start your first sponsorship.</td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: left;">3.  Bookmark a beacon from the Idee directory and then create your first post.</td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: left;">4.  Ponder the current weekly question and when ready post extension/answer.</td>
    </tr>

@endsection
@section('messageType')
    <tr><td>System Message</td></tr>
    <tr><td>Verification</td></tr>
@stop