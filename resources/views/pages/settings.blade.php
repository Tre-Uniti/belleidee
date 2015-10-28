@extends('app')

@section('siteTitle')
    Settings
@stop
@section('topLeftMenu')

@stop
@section('leftProfile')
    <h1>Amaricus</h1>

    <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">100</button></a>
    <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "navButton">1000</button></a>


    <p>This is someone's motto, let's see how long it can be
        Should be at least 3 lines long by default. Right?  And one One more line yes</p>
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

    <h2>Global Settings</h2>
    <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "navButton">Lock Profile Visibility</button></a>
    <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "navButton">Download Inspirations</button></a>
    <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "navButton">Request Support</button></a>
    <a href="{{ url('/auth/logout') }}"><button type = "button" class = "navButton">Logout</button></a>

    <h2>Motto</h2>
    <p>This is someone's motto, let's see how long it can be Should be at least 3 lines long by default. Right? And one One more line yes</p>


    <h2>Location:</h2>
    <p>Set your location for localized posting, sponsors, and belief centers</p>

    <h2>Preferred Language</h2>
    <p>Engligh</p>
    <p>Translate on the fly</p>

    <h2>Profile Pictures</h2>
    <p>Upload</p>
    <p>Translate on the fly</p>


    <h2>Contact Details and Preferences</h2>
    <p>Email:  bmcgoffin14gmail.com</p>
    <p>Notify me when:</p>
    <p>Allow sponsors to contact me when:</p>
    <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "navButton">Save Updates</button></a>

@stop
@section('centerText')
    //SiteLock Label
    <a href="#" onclick="window.open('https://www.sitelock.com/verify.php?site=www.belle-idee.org','SiteLock','width=600,height=600,left=160,top=170');" >
        <img alt="SiteLock" title="SiteLock" src="//shield.sitelock.com/shield/www.belle-idee.org"/></a>
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