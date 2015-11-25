@extends('app')
@section('siteTitle')
    Settings
@stop
@section('leftSideBar')
<div id = "leftSide">
    <div class = "innerProfileMenus">
        <h2>{{Auth::user()->handle}}</h2>
        <a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Elevation: 0</button></a>
        <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Extension: 0</button></a>
        <p>This is your motto, it is customized by the user
            It can be your motto, or another motto you like.  What happens with a third line</p>
    </div>
    <hr/>
    <div class = "innerProfileMenus">
        <h2>Posts</h2>
        <ul>
            @if ($profilePosts->isEmpty())
                <li><a href="{{url('/extension/create')}}"> <button type = "button" class = "interactButton">Create a new Extension</button></a></li>
            @else
                @foreach($profilePosts as $profilePost)
                    <li><a href="{{ action('ExtensionController@show', [$profilePost->id])}}">
                            <button type = "button" class = "interactButton">{{ $profilePost->title }}</button></a>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
    <hr/>
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
    <p>This is someone's motto, let's see how long it can be Should be at least 3 lines long by default. Right? And one One more line yes</p>


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
        <td><a href="#" onclick="window.open('https://www.sitelock.com/verify.php?site=www.belle-idee.org','SiteLock','width=600,height=500,left=160,top=170');" >
                <img alt="SiteLock" title="SiteLock" src="//shield.sitelock.com/shield/www.belle-idee.org"/></a></td>
    </table>


@stop
@section('centerFooter')

@stop
@section('rightSideBar')
<div id = "rightSide">
    <div class = "innerProfileMenus">
        <h2>Inspired By:</h2>

        <ul>
            <li><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Handle of user 1</button></a></li>
            <li><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Handle of user 2</button></a></li>
            <li><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Handle of user 3</button></a></li>
        </ul>
    </div>
    <hr/>
    <div class = "innerProfileMenus">
        <h2>Extensions</h2>
        <ul>
            @if ($profileExtensions->isEmpty())
                <li><a href="{{url('/extension/create')}}"> <button type = "button" class = "interactButton">Create a new Extension</button></a></li>
            @else
                @foreach($profileExtensions as $profileExtension)
                    <li><a href="{{ action('ExtensionController@show', [$profileExtension->id])}}">
                            <button type = "button" class = "interactButton">{{ $profileExtension->title }}</button></a>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
    <hr/>
    <div class = "innerPhotos">
        <a href="/"><img src={{asset('img/idee.png')}} alt="idee" height = "97%" width = "85%"></a>
    </div>
</div>
@stop