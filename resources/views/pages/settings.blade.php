@extends('app')
@section('siteTitle')
    Settings
@stop
@section('centerText')
    <h2>Settings of {{ $user->handle}}</h2>
<div class = "indexNav">
    <b>User Preferences:</b>
</div>
    <div class = "indexNav">
        <a href="{{ url('photo') }}"><button type = "button" class = "indexButton">Profile Photo</button></a>
        <a href="{{ url('/frequency') }}"><button type = "button" class = "indexButton">Email Frequency</button></a>
    </div>
    <div class = "indexNav">
        <b>Account:</b>
    </div>
    <div class = "indexNav">
        <a href = "{{ url('/users/deletion') }}"><button type = "button" class = "indexButton">Delete Account</button></a>
        <a href="{{ url('/home') }}"><button type = "button" class = "indexButton">Joined: {{$user->created_at->format('M-d-Y')}}</button></a>
    </div>
    <div class = "indexNav">
        <b>Sponsor</b>
    </div>
    <div class = "indexNav">
        <a href="{{ url('/sponsors/'. $sponsor->id) }}"><button type = "button" class = "indexButton">{{$sponsor->name}}</button></a>
        <a href="{{ url('/sponsors/'. $sponsor->id) }}"><button type = "button" class = "indexButton">Sponsorship: {{ $days }} days</button></a>
    </div>
    <div class = "indexNav">
        <b>Resources:</b>
    </div>
    <div class = "indexNav">
        <a href="{{ url('/gettingStarted') }}"><button type = "button" class = "indexButton">Getting Started</button></a>
        <a href="{{ url('/tutorials') }}"><button type = "button" class = "indexButton">Tutorials</button></a>
    </div>

    <div class = "indexNav">
        <b>Security Settings:</b>
        </div>
    <div class = "indexNav">
      <a href="#" onclick="window.open('https://www.sitelock.com/verify.php?site=www.belle-idee.org','SiteLock','width=600,height=500,left=160,top=170');" >
          <img alt="SiteLock" title="SiteLock" src="//shield.sitelock.com/shield/www.belle-idee.org"/></a>

        <a href="https://ssl.comodo.com/ev-ssl-certificates.php">
            <img src="https://ssl.comodo.com/images/comodo_secure_113x59_white.png" alt="EV SSL Certificate" width="115" height="65"></a>
  </div>




@stop
@section('centerFooter')
    @if($user->type > 0)
        <a href="{{ url('/moderator') }}"><button type = "button" class = "navButton">Moderator</button></a>
    @endif
    @if($user->type > 1)
        <a href="{{ url('/admin') }}"><button type = "button" class = "navButton">Admin</button></a>
    @endif
@stop
