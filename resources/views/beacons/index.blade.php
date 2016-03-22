@extends('app')
@section('siteTitle')
    Beacons
@stop

@section('centerText')
    <div>
    <h2>Beacon Directory</h2>
        <table style="display: inline-block;">
            <tr>
                <td><a href={{ url('/beacons/top')}}>Top Beacons</a></td>
                <td><a href={{ url('/beacons/search')}}>Search</a></td>
                <td><a href={{ url('/beaconRequests')}}>New Requests</a></td>
            </tr>
        </table>
    </div>
    <div style = "width: 50%; float: left;">
        <h4>Name</h4>
    </div>
    <div style = "width: 50%; float: right;">
        <h4>Tag</h4>
    </div>

        @foreach ($beacons as $beaconIndex)
            <div class = "listResource">
            <div class = "listResourceLeft">
            <a href="{{ action('BeaconController@show', [$beaconIndex->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $beaconIndex->name }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('BeaconController@listTagged', [$beaconIndex->beacon_tag])}}"><button type = "button" class = "interactButton">{{ $beaconIndex->beacon_tag }}</button></a>
            </div>
            </div>
        @endforeach

@stop
@section('centerFooter')
    {!! $beacons->render() !!}
@stop



