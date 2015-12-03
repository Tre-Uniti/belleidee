@extends('app')
@section('siteTitle')
    Settings
@stop
@section('leftSideBar')
    <div>
        <h2>{{$user->handle}}</h2>

        <div class = "innerPhotos">
            <a href="/"><img src={{asset('img/backgroundLandscape.jpg')}} alt="idee" height = "97%" width = "85%"></a>
        </div>
    </div>
@stop
@section('centerText')
    <h2>The Settings of {{Auth::user()->handle}}</h2>
    <a href="{{ url('/navGuide') }}"><button type = "button" class = "navButton">Navigation Guide</button></a>
    <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Download Inspirations</button></a>
    <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Request Support</button></a>
    <a href="{{ url('/invites') }}"><button type = "button" class = "navButton">Invite Friends</button></a>
    <a href="{{ url('/auth/logout') }}"><button type = "button" class = "navButton">Logout</button></a>
    <h4>Motto</h4>

    <h4>Contact Details and Preferences</h4>
    <p>Email:  bmcgoffin14gmail.com (Set email level)</p>

    <h4>Your Sponsor</h4>

    <table align = "center">
        <thead>
        <tr><th>Name</th>
            <th># Days</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        <tr><td>Belle-Idee</td>
            <td>1</td>
            <td>Active</td>
        </tr>
        <tr>
            <td colspan = 3" ><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">View Sponsor</button></a>
                <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Change Sponsor</button></a>
            </td>
        </tr>
        </tbody>
    </table>

    <table align = "center" style = "margin: 15px auto">
        <tr>
            <th>Scanner:</th><th>Certificate:</th>
        </tr>
        <tr>
        <td><a href="#" onclick="window.open('https://www.sitelock.com/verify.php?site=www.belle-idee.org','SiteLock','width=600,height=500,left=160,top=170');" >
                <img alt="SiteLock" title="SiteLock" src="//shield.sitelock.com/shield/www.belle-idee.org"/></a></td>
        <td>
            <a href="https://ssl.comodo.com/ev-ssl-certificates.php">
                <img src="https://ssl.comodo.com/images/comodo_secure_113x59_white.png" alt="EV SSL Certificate" width="113" height="59" style="border: 0px;"></a>
        </td>
        </tr>
    </table>


@stop
@section('centerFooter')

@stop
@section('rightSideBar')
    <h2>Hosted</h2>

    <div class = "innerPhotos">
        <a href="/"><img src={{asset('img/idee.png')}} alt="idee" height = "97%" width = "85%"></a>
    </div>
@stop