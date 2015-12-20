@extends('app')
@section('siteTitle')
    Beacons
@stop

@include('beacons.leftSide')

@section('centerText')
    <h2>Beacons</h2>
    <div style = "width: 50%; float: left;">

    <select>
    <option>Top Elevated</option>
    <option>Top Extended</option>
        <option>With Beacon</option>
        <option>Legacy Posts</option>
    </select>
    </div>

    <div style = "width: 50%; float: right;">
    <select>
        <option>Today</option>
        <option>Week</option>
        <option>Month</option>
        <option>2015</option>
    </select>
        </div>

        @foreach ($beacons as $beacon)

            <div class = "listResource">
            <div class = "listResourceLeft">
            <a href="{{ action('BeaconController@show', [$beacon->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $beacon->name }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('UserController@show', [$beacon->user_id])}}"><button type = "button" class = "interactButton">{{ $beacon->name }}</button></a>
            </div>
            </div>

        @endforeach


@stop
@section('centerFooter')
    {!! $beacons->render() !!}
@stop

@include('posts.rightSide')


