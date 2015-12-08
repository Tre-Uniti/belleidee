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
    background: linear-gradient(#7dff23, #188BC0);">Login</button></a></td>
    </tr>
    <tr>
        <td colspan = "3">
            <p>We are honored to have you along for the journey and look forward to reading your beliefs and inspirations.</p>
            <p>Below are 7 important notes to remember about Idee, typically the first thing users do is change their sponsor or post their first inspiration.</p>
        </td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: left;">1.  Zoko is the first user, mod, and admin of Belle-Idee, the account is maintained by the CEO of Tre-Uniti</td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: left;">2.  It is our belief that the majority of world beliefs seek to enlighten the mind and/or spirit</td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: left;">3.  We (the users) are free to post our beliefs so long as users and moderators don't find them intolerant of others</td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: left;">4.  The Weekly Question is asked by the user whose answer to the last question was most inspirational (Elevation+Extension)</td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: left;">5.  Users must select a sponsor who may send 3 levels of promotions for continuous sponsorship and loyalty</td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: left;">6.  Beacon centers are places of worship like Churches, Synagogues, Mosques, Temples or thought (Atheism)</td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: left;">7.  We are open source, you are free customize your local fork and download any posts for offline use</td>
    </tr>
@endsection
@section('messageType')
    <tr><td>System Message</td></tr>
    <tr><td>Verification</td></tr>
@stop