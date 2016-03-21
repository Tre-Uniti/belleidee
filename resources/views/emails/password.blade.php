@extends('emails.base')
@section('emailContent')
   <tr>
       <td colspan="3">
           Greetings {{$user->handle}}
       </td>
   </tr>
   <tr>
       <td colspan="3">
           <a href="{{ url('password/reset/'.$token) }}"><button type = "button" style = "padding: 8px 13px;
    font-family: 'Open Sans', Arial, serif;
    font-size: 100%;
    border-radius: 4px;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border: 1px solid #003300;
    text-shadow: 3px 3px 10px #000000;
    color: #FFFFFF;
    background: linear-gradient(#7dff23, #188BC0);">Please Click here</button></a>
       </td>
   </tr>
   <tr>
       <td colspan="3">
           to reset your password.
       </td>
   </tr>
@stop

@section('messageType')
    <tr><td>System Message</td></tr>
    <tr><td>Password Reset</td></tr>
    @stop