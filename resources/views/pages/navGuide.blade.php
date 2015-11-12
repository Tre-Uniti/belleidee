@extends('app')

@section('siteTile')
    Navigation Guide
@stop

@section('centerText')
        <hr/>
    <table align = "center" style = "margin-bottom: 2%;">
        <tr>
            <th colspan = "7" style = "font-size: 150%;">Top Navigation</th>
        </tr>
        <tr>
            <td ><a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Idee Directory</button></a></td>
            <td><a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Questions</button></a></td>
            <td><a href="{{ url('/home') }}"><button type = "button" class = "navButton">Your Home</button></a></td>
        </tr>
        <tr>
            <td class = "leftTDAlign">Explore the Idee directory of available Sponsors and Beacons.</td>
            <td class = "leftTDAlign">Discover past and present Questions and Winners.</td>
            <td class = "leftTDAlign">Your inspiration connectivity, sponsor, beliefs, legacy and current question.</td>
        </tr>
        <tr>
            <td><a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Search</button></a></td>
            <td><a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Settings</button></a></td>
            <td><a href="{{ url('/home') }}"><button type = "button" class = "navButton">/-\</button></a></td>
        </tr>
        <tr>
            <td class = "leftTDAlign">Fill the input field text to search for Handles and Post or Extension titles.</td>
            <td class = "leftTDAlign">View or change user settings and check site security status.</td>
            <td class = "leftTDAlign">Redirect to Tre-Uniti website, the business entity of Belle-Idee.</td>
        </tr>
    </table>

    <table align = "center" style = "margin-bottom: 2%;">
        <tr>
            <th colspan = "7" style = "font-size: 150%;">General Navigation</th>
        </tr>
        <tr>
            <td><h4>Content</h4></td>
            <td><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Interact</button></a></td>
            <td><h4>Photos</h4></td>
        </tr>
        <tr>
            <td class = "leftTDAlign">Hover/tap center to hide sides, mobile double tap for auto-zoom.</td>
            <td class = "leftTDAlign">Link to Handle, Post, Extension, also used for Elevation/Intolerance.</td>
            <td class = "leftTDAlign">Left photo set by users, right photo either their Sponsor or Beacon.</td>
        </tr>
    </table>

    <table align = "center" style = "margin-bottom: 2%;">
        <tr>
            <th colspan = "7" style = "font-size: 150%;">Bottom Navigation</th>
        </tr>
        <tr>
            <td><a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Discover Posts</button></a></td>
            <td><a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Bookmarks</button></a></td>
            <td><a href="{{ url('/home') }}"><button type = "button" class = "navButton">Create Post</button></a></td>
        </tr>
        <tr>
            <td class = "leftTDAlign">Discover Posts and Extensions from users, legacy accounts, and artists.</td>
            <td class = "leftTDAlign">Rediscover those Users, Posts, and Extensions you have bookmarked.</td>
            <td class = "leftTDAlign">Redirect to Tre-Uniti website, the business entity of Belle-Idee</td>
        </tr>
            <tr>
            <td><a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Song Lyrics</button></a></td>
            <td><a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Play/Pause</button></a></td>
            <td><a href="{{ url('/home') }}"><button type = "button" class = "navButton">Next Song</button></a></td>
        </tr>

            <tr>
            <td class = "leftTDAlign">Load the Lyrics post by the Artist of the current song playing.</td>
            <td class = "leftTDAlign">Play or Pause the current song.</td>
            <td class = "leftTDAlign">Play the next song in the monthly music queue.</td>
        </tr>
    </table>
        <table align = "center">
            <tr>
                <th colspan = "7" style = "font-size: 150%;">Footer Navigation</th>
            </tr>
            <tr>
                <td class = "leftTDAlign">Shows when needed at the very bottom, such as below.</td>
            </tr>
        </table>
    <hr/>
@stop

@section('centerFooter')
    <div id = "centerFooter">
    <a href="{{ url('/demo') }}"><button type = "button" class = "navButton">View Demo Post</button></a>
    </div>
    @stop
