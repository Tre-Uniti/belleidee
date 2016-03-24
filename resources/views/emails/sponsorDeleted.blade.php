@extends('emails.base')

@section('emailContent')
    <tr>
        <td colspan = "3"><h3>Greetings, {{$user->handle}}</h3></td>
    </tr>
    <tr>
        <td colspan="3">Your sponsor request for <b>{{ $sponsorTitle }}</b> did not become an Idee Sponsor.</td>
    </tr>
    <tr>
        <td colspan="3">Thank you for requesting we contact them however we were unable to create an Idee Sponsor for them.</td>
    </tr>
    <tr>
        <td colspan="3">Requests are deleted when they are turn down our offer, are a duplicate, or don't qualify as a Sponsor.</td>
    </tr>

@endsection
@section('messageType')
    <tr><td>System Message</td></tr>
    <tr><td>Sponsor Deleted</td></tr>
@stop