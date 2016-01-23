@extends('app')
@section('siteTitle')
    Settings
@stop
@section('centerText')
    <h2>Settings of {{ $user->handle}}</h2>
    <a href="{{ url('photo') }}"><button type = "button" class = "navButton">Change Profile Photo</button></a>
    <a href="{{ url('/sponsors') }}"><button type = "button" class = "navButton">Change Sponsor</button></a>
    <hr/>
    <table align = "center">
        <thead>
        <tr><th>Sponsor Name</th>
            <th># Days</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        <tr><td>{{ $sponsor->name }}</td>
            <td>{{ $days }}</td>
            <td>{{ $sponsor->status }}</td>
        </tr>
        <tr>
            <td colspan = 3" ><a href="{{ url('/sponsors/'. $sponsor->id) }}"><button type = "button" class = "interactButton">View Sponsor Page</button></a>

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
    @if($user->type > 0)
        <a href="{{ url('/moderator') }}"><button type = "button" class = "navButton">Moderator</button></a>
    @endif
    @if($user->type > 1)
        <a href="{{ url('/admin') }}"><button type = "button" class = "navButton">Admin</button></a>
    @endif
@stop
