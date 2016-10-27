@extends('emails.base')

@section('emailContent')
    <tr>
        <td colspan = "3"><h3>Welcome {{$user->handle}} to Belle-Idee!</h3></td>
    </tr>
    <tr>
        <td colspan="3"><b>How do I get started now that I'm confirmed?</b></td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: left;">1.  Explore, elevate, and extend the <a href="{{ url("/posts") }}" style = "color: black;">posts</a> and <a href="{{ url("/extensions") }}" style = "color: black;">extensions</a> within the community.</td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: left;">2.  Follow an inspirational <a href="{{ url("/users") }}" style = "color: black;">user</a> from the directory to stay caught up with their posts.</td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: left;">2.  Connect to a <a href="{{ url("/beacons") }}" style = "color: black;">beacon</a> from the directory and then create your first post.</td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: left;">3.  If you don't feel ready to publicly post you can always create your first <a href="{{ url("/drafts") }}" style = "color: black;">draft</a> (private) and later convert it to a post.</td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: left;">4.  Select a <a href="{{ url("/sponsors") }}" style = "color: black;">sponsor</a> from the directory to start your first sponsorship.</td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: left;">5.  Ponder the current <a href="{{ url("/questions") }}" style = "color: black;">Community Question</a> and when ready post your answer.</td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: left;">6.  Start exploring the various <a href="{{ url("/beliefs") }}" style = "color: black;">beliefs</a> within the site to assist you on your spiritual journey. </td>
    </tr>

@endsection
@section('messageType')
    <tr><td>System Message</td></tr>
    <tr><td>Confirmed</td></tr>
@stop