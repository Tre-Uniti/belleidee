@extends('app')
@section('siteTitle')
    Beacons
@stop

@include('beacons.leftSide')

@section('centerText')
    <div>
    <h2>Beacons</h2>
        <table style="display: inline-block;">
            <tr>
                <td><a href={{ url('/beacons/create')}}>Top Beacons</a></td>
                <td><a href={{ url('/beacons/create')}}>Search</a></td>
                <td><a href={{ url('/beacons/create')}}>Request New</a></td>
            </tr>
        </table>
    </div>
    <div style = "width: 50%; float: left;">
        <h4>Name</h4>
    </div>
    <div style = "width: 50%; float: right;">
        <h4>Tag</h4>
    </div>

        @foreach ($beacons as $beacon)
            <div class = "listResource">
            <div class = "listResourceLeft">
            <a href="{{ action('BeaconController@show', [$beacon->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $beacon->name }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('BeaconController@listTagged', [$beacon->beacon_tag])}}"><button type = "button" class = "interactButton">{{ $beacon->beacon_tag }}</button></a>
            </div>
            </div>
        @endforeach

@stop
@section('centerFooter')
    {!! $beacons->render() !!}
@stop

@include('posts.rightSide')


