@extends('emails.base')

@section('emailContent')
    <tr>
        <td colspan = "3" style = "text-align: center"><h3>Greetings, {{$user->handle}}</h3></td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: center">A new Community Question has been posted!</td>
    </tr>
    <tr>
        <td colspan="3"><hr/></td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: center"><h3>{{ $question->question }}</h3></td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: center">
            <a href="{{ url("/extensions/question/{$question->id}") }}"><button type = "button" style = "padding: 8px 13px;
    font-family: 'Open Sans', Arial, serif;
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
    background: -moz-linear-gradient(#7dff23, #188BC0);">Post your answer</button></a>
        </td>
    </tr>
    <tr>
        <td colspan="3"><br/></td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: center">Asked by:</td>
    </tr>
    <tr>
        <td colspan="3" style = "text-align: center">
            <a href="{{ url("/users/{$askedBy->id}") }}"><button type = "button" style = "padding: 8px 13px;
    font-family: 'Open Sans', Arial, serif;
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
    background: -moz-linear-gradient(#7dff23, #188BC0);">{{ $askedBy->handle }}</button></a>
        </td>
    </tr>

@endsection
@section('messageType')
    <tr><td>Community Message</td></tr>
    <tr><td>legacy Report</td></tr>
@stop