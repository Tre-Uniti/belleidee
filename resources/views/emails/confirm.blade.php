@extends('emails.base')

@section('emailContent')
    <tr>
        <td colspan = "3"><h3>Thank you {{$user->handle}}, for signing up!</h3></td>
    </tr>
    <tr>
        <td>Please click on the button to sign-in:<a href="{{ url("auth/confirm/{$user->emailToken}") }}"><button type = "button" style = "padding: 8px 13px;
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
            <p>Below is a quick guide to the ideas and names of the site.</p>
        </td>
    </tr>
    <tr>
        <td colspan="3"><p>1.  Zoko is the first user, mod, and admin of Belle-Idee, the account is maintained by the CEO of Tre-Uniti</p></td>
    </tr>
    <tr>
        <td colspan="3"><p>2.  It is our belief that the majority of world beliefs seek to enlighten the mind and/or spirit</p></td>
    </tr>
    <tr>
        <td colspan="3"><p>3.  We (the users) are free to post our beliefs so long as users and moderators don't find them intolerant of others </p></td>
    </tr>
    <tr>
        <td colspan="3"><p>4.  The Weekly Question is asked by the user whose answer to the last question was most inspirational (Elevation+Extension)</p></td>
    </tr>
    <tr>
        <td colspan="3"><p>5.  Account types: User, Artist, Legacy, Mod, Admin</p></td>
    </tr>
    <tr>
        <td colspan="3"><p>6.  Account types: User, Artist, Legacy, Mod, Admin</p></td>
    </tr>
    <tr>
        <td colspan="3"><p>7.  Account types: User, Artist, Legacy, Mod, Admin</p></td>
    </tr>
@endsection
@section('messageType')
    Email Verification
@stop