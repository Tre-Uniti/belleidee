@extends('app')
@section('siteTitle')
    Search Beacons
@stop

@section('centerText')
    <div>
        <h2>Search Results</h2>
        <table style="display: inline-block;">
            <tr>
                <td><a href={{ url('/beacons/')}}>All Beacons</a></td>
                <td><a href={{ url('/beacons/search')}}>Beacon Search</a></td>
                <td><a href={{ url('/search')}}>Global Search</a></td>
            </tr>
        </table>
    </div>
        <div style = "width: 50%; float: left;">
            <h4>Beacon</h4>
        </div>
        <div style = "width: 50%; float: right;">
            <h4>Beacon Tag</h4>
        </div>
        @foreach ($results as $result)
            <div class = "listResource">
                <div class = "listResourceLeft">
                    <a href="{{ action('BeaconController@show', [$result->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{$result->name}}</button></a>
                </div>
                <div class = "listResourceRight">
                    <a href="{{ action('BeaconController@listTagged', [$result->beacon_tag])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{$result->beacon_tag}}</button></a>
                </div>
            </div>
        @endforeach

@stop
@section('centerFooter')
    {!! $results->appends(['identifier' => $identifier])->render() !!}
@stop



