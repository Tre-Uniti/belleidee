@extends('app')
@section('siteTitle')
    Moderation Portal
@stop
@section('centerText')
    <h2>Moderation Portal</h2>
    <a href="{{ url('moderator/globalMods') }}" class = "indexLink">Global Mods</a>
    <a href="{{ url('moderator/beaconMods') }}" class = "indexLink">Beacon Mods</a>
    <a href="{{ url('intolerances') }}" class = "indexLink">Intolerance Reports</a>
    <p>Your Beacons</p>

    <hr class = "contentSeparator"/>
    @include('beacons._beaconCards')

@stop
@section('centerFooter')
    {!! $beacons->render() !!}
@stop