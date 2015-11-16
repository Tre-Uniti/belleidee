@extends('app')

@section('siteTitle')
    Settings
@stop
@include('pages.leftSide')

@section('centerText')
    <h2>The Settings of {{Auth::user()->handle}}</h2>
    <a href="{{ url('/navGuide') }}"><button type = "button" class = "navButton">Navigation Guide</button></a>
    <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Download Inspirations</button></a>
    <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Request Support</button></a>
    <a href="{{ url('/invites') }}"><button type = "button" class = "navButton">Invite Friends</button></a>
    <a href="{{ url('/auth/logout') }}"><button type = "button" class = "navButton">Logout</button></a>
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

    <table align = "center" style = "margin: 15px auto">
        <tr>
            <th>Scanner:</th><th>Certificate:</th>
        </tr>
        <td><a href="#" onclick="window.open('https://www.sitelock.com/verify.php?site=www.belle-idee.org','SiteLock','width=600,height=500,left=160,top=170');" >
                <img alt="SiteLock" title="SiteLock" src="//shield.sitelock.com/shield/www.belle-idee.org"/></a></td>
    </table>


@stop
@section('centerFooter')

@stop

@include('pages.rightSide')
