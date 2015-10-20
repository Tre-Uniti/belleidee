@extends('app')
@section('siteTitle')
    Home
@stop
@section('handle')
{{Auth::user()->handle}}
@stop
@section('centerMenu')

<h1>Belief Centers</h1>
<a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Atheism</button></a>
<a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Adaptia</button></a>
<a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Ba Gua</button></a>
<a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Buddhism</button></a>
<a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Christianity</button></a>
<a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Druze</button></a>
<a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Hinduism</button></a>
<a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Islam</button></a>
<a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Judaism</button></a>
<a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Native</button></a>
<a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Taoism</button></a>
<a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Urantia</button></a>



@stop
@section('centerText')
    <h1>Question of the Week:</h1>
    <h4>How are we influenced by our emotions, what purpose do they serve?</h4>
    <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Elevate: 723 422 923</button></a>
    <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "navButton">Extend: 232 300 2</button></a>
@stop
@section('centerFooter')
    <h2>Your Sponsor</h2>
    <table align = "center" style = "border: 0px solid white;">
        <thead>
        <tr><th>Name</th>
            <th># Days</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        <tr><td style = "border: 1px solid white;">Belle-Idee</td>
            <td style = "border: 1px solid white;">1</td>
            <td style = "border: 1px solid white;">Active</td>
        </tr>
        <tr>
            <td colspan = 3" style = "border: 0px solid white;" ><a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">View Sponsor</button></a>
                <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "navButton">Change Sponsor</button></a>
            </td>
        </tr>
        </tbody>
    </table>
@stop
