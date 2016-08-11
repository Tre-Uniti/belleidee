@extends('emails.base')

@section('emailContent')
    <tr>
        <td colspan = "3"><h3>Support request from {{$user->handle}}</h3></td>
    </tr>
    <tr>
        <td colspan = "3"><h3>Email associated with Handle: {{$user->email}}</h3></td>
    </tr>
    <tr>
        <td>{{ $support->user_id }} - </td>
        <td>{{ $support->created_at->format('M-d-Y') }} - </td>
        <td>Idee-{{ $support->type }}</td>

    </tr>
    <tr>
        <td colspan="3">{{ $support->request }}</td>
    </tr>

    <tr>
        <td colspan="3">
            <a href="{{ url("supports/{$support->id}") }}"><button type = "button" style = "padding: 8px 13px;
    font-family: 'Open Sans', Arial, serif;
    font-size: 100%;
    border-radius: 4px;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border: 1px solid #202020;
    color: #FFFFFF;
    background-color: #27AE60">View the Support Request</button></a>
        </td>
    </tr>

@endsection
@section('messageType')
    <tr><td>System Message</td></tr>
    <tr><td>Support</td></tr>
@stop