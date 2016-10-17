
@extends('emails.base')
@section('emailContent')
    <tr>
        <td colspan="3">
            Greetings {{$user->handle}}
        </td>
    </tr>
    <tr>
        <td colspan="3">
            Click here to reset your password: <a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
        </td>
    </tr>
@stop

@section('messageType')
    <tr><td>System Message</td></tr>
    <tr><td>Password Reset</td></tr>
@stop