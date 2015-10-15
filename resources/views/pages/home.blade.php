@extends('app')

@section('siteTitle')
    Home
@stop
@section('topLeftMenu')

@stop
@section('leftProfile')
<h1>Amaricus</h1>

<a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">100</button></a>
<a href="{{ url('/auth/nymi') }}"><button type = "button" class = "navButton">1000</button></a>


<p>This is someone's motto, let's see how long it can be
Should be at least 3 lines long by default. Right? And one One more line yes until we reach the end</p>
    <hr/>
<h2>Top 3</h2>

<ul style = "text-align: left;">
    <li><a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Create and Post your first inspiration</button></a></li>
    <li><a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Post a second</button></a></li>
    <li><a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Post a third</button></a></li>
</ul>
<hr/>
    <a href="/"><img src={{asset('img/idee.png')}} alt="idee" height = "70%" width = "70%"></a>
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
<table align = "center" border = "1">
    <tr><td>Sponsor Name:</td><td># Days Continuous</td><td>Status</td></tr>
    <tr><td>Starbucks</td><td>27 Days</td><td>Active</td></tr>
</table>
<a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">View Sponsor</button></a>
<a href="{{ url('/auth/nymi') }}"><button type = "button" class = "navButton">Change Sponsor</button></a>



@stop
@section('centerText')

@stop
@section('centerBottom')

@stop
@section('topRightMenu')

@stop
@section('rightProfile')
    <h2>Inspired By:</h2>
    <ul style = "text-align: left;">
        <li><a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Extend someone elses' post</button></a></li>
        <li><a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Extend 2 Posts</button></a></li>
        <li><a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Extend 3 Posts</button></a></li>
    </ul>
    <hr/>
    <h2>Inspires:</h2>
    <ul style = "text-align: left;">
        <li><a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Need 1 person to extend your post</button></a></li>
        <li><a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">2nd person</button></a></li>
        <li><a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">3rd person</button></a></li>
    </ul>
    <hr/>
    <a href="/"><img src={{asset('img/idee.png')}} alt="idee" height = "70%" width = "70%"></a>
@stop
@section('bottomRightMenu')

@stop