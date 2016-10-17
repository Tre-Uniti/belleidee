
@extends('emails.base')
@section('emailContent')
    <tr>
        <td colspan="3">
            Greetings {{$user->handle}}
        </td>
    </tr>
    <tr>
        <td colspan="3">
            Click <a
                    style = "padding:8px 13px;
                             display: inline-block;
                             text-align: center;
                             text-decoration: none;
                             color:  #FFFFFF;
                             font-family: Open Sans, Arial, serif;
                             border-radius:7px;
                             -moz-border-radius:7px;
                             -webkit-border-radius:7px;
                             border: 1px solid #2C3E50;
                             background-color: #2ECC71 ;
                             font-weight: 500;"
                    href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> here </a> to reset your password.
        </td>
    </tr>
@stop

@section('messageType')
    <tr><td>System Message</td></tr>
    <tr><td>Password Reset</td></tr>
@stop