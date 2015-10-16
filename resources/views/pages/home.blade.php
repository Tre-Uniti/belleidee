@extends('app')

@section('siteTitle')
    Home
@stop
@section('topLeftMenu')

@stop
@section('handle')
Amaricus
@stop
@section('bottomLeftMenu')

@stop
@section('centerMenu')

<h1>Belief Centers</h1>
<a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Atheism</button></a>
<a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Buddhism</button></a>
<a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Cheondoism</button></a>
<a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Christianity</button></a>
<a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Druze</button></a>
<a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Hinduism</button></a>
<a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Islam</button></a>
<a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Jainism</button></a>
<a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Judaism</button></a>
<a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Native American</button></a>
<a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Taoism</button></a>
<a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Urantia</button></a>
<a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Sikhism</button></a>
<a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Shinto</button></a>

<h1>Question of the Week:</h1>
    <h4>How are we influenced by our emotions, what purpose do they serve?</h4>
<a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Elevate: 723 422 923</button></a>
<a href="{{ url('/auth/nymi') }}"><button type = "button" class = "navButton">Extend: 232 300 2</button></a>
<h2>Your Sponsor</h2>
<table align = "center">
    <thead>
    <tr><th>Name</th>
        <th># Days</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    <tr><td>Belle-Idee</td>
        <td >1</td>
        <td >Active</td>
    </tr>
    <tr>
        <td colspan = 3" ><a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">View Sponsor</button></a>
            <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "navButton">Change Sponsor</button></a>
        </td>
    </tr>
    </tbody>
</table>
@stop
@section('centerText')

@stop
@section('centerBottom')

@stop
@section('topRightMenu')

@stop
@section('rightProfile')

@stop
@section('bottomRightMenu')

@stop