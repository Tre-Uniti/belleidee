@extends('app')

@section('siteTitle')
    Settings
@stop
@section('handle')
    {{Auth::user()->handle}}
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
    <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Lock Profile Visibility</button></a>
    <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Download Inspirations</button></a>
    <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Request Support</button></a>
    <a href="{{ url('/invites') }}"><button type = "button" class = "navButton">Invite Friends</button></a>
    <a href="{{ url('/auth/logout') }}"><button type = "button" class = "navButton">Logout</button></a>


@stop
@section('centerText')

    <h4>Motto</h4>
    <p>This is someone's motto, let's see how long it can be Should be at least 3 lines long by default. Right? And one One more line yes</p>


    <h4>Location:</h4>
    <p>Set your location for localized posting, sponsors, and belief centers</p>

    <h4>Preferred Language</h4>
    <p>Translate on the fly</p>

    <h4>Profile Pictures</h4>
    <p>Upload</p>



    <h4>Contact Details and Preferences</h4>
    <p>Email:  bmcgoffin14gmail.com (Set email level)</p>

    <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "navButton">Save Updates</button></a>
@stop
@section('centerFooter')
    <a href="#" onclick="window.open('https://www.sitelock.com/verify.php?site=www.belle-idee.org','SiteLock','width=600,height=600,left=160,top=170');" >
        <img alt="SiteLock" title="SiteLock" src="//shield.sitelock.com/shield/www.belle-idee.org"/></a>
@stop
@section('topRightMenu')

@stop
@section('rightProfile')
    <h2>Inspired By:</h2>
    <ul style = "text-align: left;">
        <li><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Extend someone elses' post</button></a></li>
        <li><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Extend 2 Posts</button></a></li>
        <li><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Extend 3 Posts</button></a></li>
    </ul>
    <hr/>
    <h2>Inspires:</h2>
    <ul style = "text-align: left;">
        <li><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Need 1 person to extend your post</button></a></li>
        <li><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">2nd person</button></a></li>
        <li><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">3rd person</button></a></li>
    </ul>
    <hr/>
    <a href="/"><img src={{asset('img/idee.png')}} alt="idee" height = "70%" width = "70%"></a>
@stop
@section('bottomRightMenu')

@stop