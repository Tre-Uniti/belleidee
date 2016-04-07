@extends('app')
@section('siteTitle')
    Settings
@stop
@section('centerText')
    <h2>Settings of {{ $user->handle}}</h2>
    <table align = "center">
        <tr>
            <th colspan="2">Resources:</th>
        </tr>
        <tr>
            <td><a href="{{ url('/training') }}"><button type = "button" class = "interactButton">Training</button></a></td>
            <td><a href="{{ url('/workshops') }}"><button type = "button" class = "interactButton">Workshops</button></a></td>
        </tr>
    </table>
    <table align = 'center'>
        <tr>
            <th colspan="2">User Preferences:</th>
        </tr>
        <tr>
            <td><a href="{{ url('photo') }}"><button type = "button" class = "interactButton">Profile Photo</button></a></td>
            <td><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Email Frequency</button></a></td>
        </tr>
    </table>
    <table align = "center">
        <tr>
            <th colspan="2">Account:</th>
        </tr>
        <tr>
            <td><a href = "{{ url('/users/deletion') }}"><button type = "button" class = "interactButton">Delete Account</button></a></td>
            <td><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Download Posts</button></a></td>
        </tr>
    </table>

    <table align = "center">
        <tr>
            <th colspan="2">Sponsor</th>
        </tr>
        <tr>
            <td><a href="{{ url('/sponsors/'. $sponsor->id) }}"><button type = "button" class = "interactButton">{{$sponsor->name}}</button></a>
            <td><a href="{{ url('/sponsors/'. $sponsor->id) }}"><button type = "button" class = "interactButton">Sponsorship: {{ $days }} days</button></a></td>
        </tr>
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
    @if($user->type > 0)
        <a href="{{ url('/moderator') }}"><button type = "button" class = "navButton">Moderator</button></a>
    @endif
    @if($user->type > 1)
        <a href="{{ url('/admin') }}"><button type = "button" class = "navButton">Admin</button></a>
    @endif
@stop
