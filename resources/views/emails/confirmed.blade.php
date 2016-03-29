@extends('emails.base')

@section('emailContent')
    <tr>
        <td colspan = "3"><h3>Welcome {{$user->handle}} to Belle-Idee!</h3></td>
    </tr>
    <tr>
        <td colspan="3"><b>How do I get started now that I'm confirmed?</b></td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: left;">1.  Watch our <a href="{{ url("/training") }}" style = "color: black;">training videos</a> or attend a local <a href="{{ url("/workshops") }}" style = "color: black;">workshop</a>.</td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: left;">2.  Read the  <a href="{{ url("/posts/1") }}" style = "color: black;">Commencement post</a> or other informative posts by <a href="{{ url("/users/1") }}" style = "color: black;">Tre-Uniti</a></td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: left;">3.  Explore, elevate, and extend the <a href="{{ url("/posts") }}" style = "color: black;">posts</a> and <a href="{{ url("/extensions") }}" style = "color: black;">extensions</a> within the community.</td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: left;">4.  Bookmark a <a href="{{ url("/beacons") }}" style = "color: black;">beacon</a> from the Idee directory and then create your first post.</td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: left;">4.  If you don't feel ready to publicly post you can always create your first draft (private) and later convert it to a post.</td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: left;">5.  Choose a <a href="{{ url("/sponsors") }}" style = "color: black;">sponsor</a> from the Idee directory to start your first sponsorship.</td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: left;">6.  Ponder the current <a href="{{ url("/questions") }}" style = "color: black;">Community Question</a> and when ready post an extension.</td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: left;">*  By confirming you agree to receive emails from Idee regarding your activity in the community. *</td>
    </tr>

@endsection
@section('messageType')
    <tr><td>System Message</td></tr>
    <tr><td>Confirmed</td></tr>
@stop