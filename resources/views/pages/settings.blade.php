@extends('app')
@section('siteTitle')
    Settings
@stop
@section('centerText')
    <h1>Settings for {{ $user->handle}}</h1>

    <div class = "contentCard">
        <div class = "cardTitleSection">
            <h3>
                User Preferences
            </h3>
        </div>
        <div class = "cardHandleSection">
            <p>
                Settings customized by and for you.
            </p>
        </div>
        <div class = "footerSection">
            <div class = "leftSection">
                <div class = "leftIcon">
                    <a href="{{ url('photo') }}" class = "indexLink">Photo</a>
                    <span class="tooltiptext">Change your profile photo</span>
                </div>
            </div>
            <div class = "centerSection">
                <a href="{{ url('/frequency') }}" class = "indexLink">Email Frequency</a>
                <span class="tooltiptext">Change the frequency of emails received</span>
            </div>
            <div class = "rightSection">
                <div class = "rightIcon">
                    <a href="{{ url('/theme') }}" class = "indexLink">Theme</a>
                    <span class="tooltiptext">Change the default color theme</span>
                </div>
            </div>
        </div>
    </div>

    <div class = "contentCard">
        <div class = "cardTitleSection">
            <h3>
                Location
            </h3>
        </div>
        <div class = "cardHandleSection">
            <p>
                Change the scope of your location (set by latest Beacon interaction, or by custom).
            </p>
            <p>Current Location: {{ $location }}</p>
        </div>
        <div class = "footerSection">
            <div class = "leftSection">
                <div class = "leftIcon">
                    <a href="{{ url('/newLocation') }}" class = "indexLink">Custom</a>
                    <span class="tooltiptext">Specify a custom location</span>
                </div>
            </div>

            <div class = "rightSection">
                <div class = "rightIcon">
                    <a href="{{ url('/local') }}" @if(strlen($location) > 6) class = "navLink" @else class = "indexLink" @endif>Local</a>
                    <a href="{{ url('/country') }}" @if(strlen($location) < 3) class = "navLink" @else class = "indexLink" @endif>Country</a>
                    <a href="{{ url('/global') }}" @if($location == 'Global') class = "navLink" @else class = "indexLink" @endif>Global</a>
                    <span class="tooltiptext">Change the scope of your location</span>
                </div>
            </div>
        </div>
    </div>

    <div class = "contentCard">
        <div class = "cardTitleSection">
            <h3>
                Beacon
            </h3>
        </div>
        <div class = "cardHandleSection">
            <p>
                Beacon is set by connecting and posting with their beacon tag.
            </p>
        </div>
        <div class = "indexNav">
            <div class = "userConnections">
                <h4 class = "underline">Beacon</h4>
                @if(isset($beacon))
                    @if($beacon != NULL)
                        <a href={{ url('/beacons/'. $beacon->beacon_tag) }}><h4>{{ $beacon->name }}</h4></a>
                        <a href={{ url('/beacons/'. $beacon->beacon_tag) }}>{{ $beacon->beacon_tag }}</a>
                        <div><a href="{{ url('/beacons') }}" class = "indexLink">Change Beacon</a></div>
                    @endif
                @else
                    <h4>No Beacon yet</h4>
                    <a href = " {{ url('/beacons') }}">Discover one here</a>
                @endif
            </div>
        </div>
    </div>

    <div class = "contentCard">
        <div class = "cardTitleSection">
            <h3>
                Sponsor
            </h3>
        </div>
        <div class = "cardHandleSection">
            <p>Sponsor is set by starting a sponsorship, min 7 days to be eligible for all promos.</p>
        </div>
        <div class = "indexNav">
            <div class = "userConnections">
                <h4 class = "underline">Sponsor</h4>
                @if(isset($sponsor))
                    @if($sponsor != NULL)
                        <a href={{ url('/sponsors/click/'. $sponsor->id) }}><h4>{{ $sponsor->name }}</h4></a>
                        <a href={{ url('/sponsors/click/'. $sponsor->id) }}>{{ $sponsor->sponsor_tag }}</a>
                        <div><a href="{{ url('/sponsors') }}" class = "indexLink">Change Sponsor</a></div>
                    @endif
                @else
                    <h4>No Sponsor yet</h4>
                    <a href = "{{ url('/sponsors') }}">Discover one here</a>
                @endif
            </div>
        </div>
    </div>


    <div class = "contentCard">
        <div class = "cardTitleSection">
            <h3>
                Resources
            </h3>
        </div>
        <div class = "cardHandleSection">
            <p>
                Here to help you get started and inform you about Belle-idee.
            </p>
        </div>
        <div class = "footerSection">

            <div class = "centerSection">
                @if($user->startup < 5)
                <a href="{{ url('/gettingStarted') }}" class = "indexLink">Getting Started</a>
                @endif
                <a href="{{ url('/tutorials') }}" class = "indexLink">Tutorials</a>
                <a href="{{ url('/about') }}" class = "indexLink">About Belle-idee</a>
            </div>

        </div>
    </div>

    <div class = "contentCard">
        <div class = "cardTitleSection">
            <h3>
                Account
            </h3>
        </div>
        <div class = "cardHandleSection">
            <p>
                Options and details regarding your account.
            </p>
        </div>
        <div class = "footerSection">

            <div class = "centerSection">
                <a href = "{{ url('/users/deletion') }}"><button type = "button" class = "indexButton">Delete Account</button></a>
                <a href="{{ url('/home') }}"><button type = "button" class = "indexButton">Joined: {{$user->created_at->format('M-d-Y')}}</button></a>
            </div>
            <div class = "indexNav"></div>
            <p>
                <a href="/terms" target="_blank">Terms of Use | </a>
                <a href = "/privacy" target="_blank">Privacy Policy</a>
            </p>

            <div class = "indexNav">
                <a href="#" onclick="window.open('https://www.sitelock.com/verify.php?site=www.belle-idee.org','SiteLock','width=600,height=500,left=160,top=170');" >
                    <img alt="SiteLock" title="SiteLock" src="//shield.sitelock.com/shield/www.belle-idee.org"/></a>

                <a href="https://ssl.comodo.com/ev-ssl-certificates.php">
                    <img src="https://ssl.comodo.com/images/comodo_secure_113x59_white.png" alt="EV SSL Certificate" width="115" height="65"></a>
            </div>
        </div>
    </div>







@stop
@section('centerFooter')
    @if($user->type > 0)
        <a href="{{ url('/moderator') }}" class = "navLink">Moderator</a>
    @endif
    @if($user->type > 1)
        <a href="{{ url('/admin') }}" class = "NavLink">Admin</a>
    @endif
@stop

