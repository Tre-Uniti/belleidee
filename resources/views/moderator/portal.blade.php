@extends('app')
@section('siteTitle')
    Moderation Portal
@stop
@section('centerText')
    <h2>Moderation Portal</h2>

    <a href="{{ url('intolerances') }}" class = "indexLink">Intolerance Reports</a>
    <a href="{{ url('moderator/yourBeacons') }}" class = "indexLink">Your Beacons</a>

    <p>Sort by Latest:</p>
    <nav class = "infoNav">
        <ul>
            <li>
                <a href = "{{ url('/moderator') }}" class = "navLink">All Mods</a>
                <a href="{{ url('moderator/beaconMods') }}" class = "indexLink">Beacon Mods</a>
                <a href="{{ url('moderator/globalMods') }}" class = "indexLink">Global Mods</a>
            </li>
        </ul>
    </nav>
    <hr class = "contentSeparator"/>
    @include('users._userCards')

@stop
@section('centerFooter')
    {!! $users->render() !!}
@stop


