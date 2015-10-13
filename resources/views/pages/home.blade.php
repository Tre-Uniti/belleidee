@extends('app')

@section('siteTitle')
    Home
@stop
@section('topLeftMenu')

@stop
@section('leftProfile')
<h1>Amaricus</h1>

<a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">123 234 342 233</button></a>
<p>This is someone's motto, let's see how long it can be
Should be at least 3 lines long by default. Right?  One more line</p>
    <hr/>
<h2>Top 3</h2>
<ul>
    <li><a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Testimony of a Toker</button></a></li>
    <li><a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Destiny of Forgiveness</button></a></li>
    <li><a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Where to find God for your journey</button></a></li>
</ul>
<hr/>
    <a href="/"><img src={{asset('img/idee.png')}} alt="idee" height = "70%" width = "70%"></a>
@stop
@section('bottomLeftMenu')

@stop
@section('centerMenu')
    <h2>This is a title</h2>
    <p>Some things in CSS are a bit tedious to write,
        especially with CSS3 and the many vendor prefixes
        that exist. A mixin lets you make groups of CSS
        declarations that you want to reuse throughout your
        site. You can even pass in values to make your mixin
        more flexible. A good use of a mixin is for vendor
        prefixes. Here's an example for border-radius.</p>
@stop
@section('centerText')
    <hr class = "mainHr">
    <p>Some things in CSS are a bit tedious to write,
        especially with CSS3 and the many vendor prefixes
        that exist. A mixin lets you make groups of CSS
        declarations that you want to reuse throughout your
        site. You can even pass in values to make your mixin
        more flexible. A good use of a mixin is for vendor
        prefixes. Here's an example for border-radius.</p>
    <p>Some things in CSS are a bit tedious to write,
        especially with CSS3 and the many vendor prefixes
        that exist. A mixin lets you make groups of CSS
        declarations that you want to reuse throughout your
        site. You can even pass in values to make your mixin
        more flexible. A good use of a mixin is for vendor
        prefixes. Here's an example for border-radius.</p>



@stop
@section('centerBottom')

@stop
@section('topRightMenu')

@stop
@section('rightProfile')
    <h2>Inspired By:</h2>
    <select>
        <option value="Handle">Handle</option>
        <option value="Post">Post</option>
    </select>
    <ul>
        <li><a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">1Dr. Greenthumb</button></a></li>
        <li><a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Majestic</button></a></li>
        <li><a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">TheThoughtAdjuster</button></a></li>
    </ul>
    <hr/>
    <h2>Inspires:</h2>
    <ul>
        <li><a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">WhereartThou?</button></a></li>
        <li><a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">OneLoveLoveLove Love BabyaLone God</button></a></li>
        <li><a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Num1</button></a></li>
    </ul>
    <hr/>
    <a href="/"><img src={{asset('img/idee.png')}} alt="idee" height = "70%" width = "70%"></a>
@stop
@section('bottomRightMenu')

@stop