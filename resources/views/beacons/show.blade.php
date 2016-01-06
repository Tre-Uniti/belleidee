@extends('app')
@section('siteTitle')
    Show Beacon
@stop



@section('centerMenu')
    <h2>{{ $beacon->name }}</h2>
@stop

@section('centerText')
    <div>
        <table style="display: inline-block;">
        <tr>
            <th>
                <a href="{{ url('/beacons') }}">Shepherd</a>
            </th>
            <th>
                <a href="{{ url('/beacons') }}">Tag</a>
            </th>
            <th>
                <a href="{{ url('/beacons') }}">Usage</a>
            </th>

    </tr>
            <tr>
                <td><a href="{{ url('/posts/') }}">{{ $beacon->user_id }}</a>
                </td>
                <td><a href="{{ url('/beacons/tags/'.$beacon->beacon_tag) }}">{{ $beacon->beacon_tag }}</a>
                </td>
                <td><a href="{{ url('/posts/') }}">{{ $beacon->tag_usage }}</a>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <a href="{{ $beacon->website }}">Beacon Website</a>
                </td>
            </tr>
    </table>
        <hr/>
        <h2>Top 7</h2>


        </div>
@stop

@section('centerFooter')
    <div id = "centerFooter">
        @if($beacon->beacon_tag != 'No-Beacon')
        <a href="{{ url('/bookmarks/beacons/'.$beacon->beacon_tag) }}"><button type = "button" class = "navButton">Bookmark</button></a>
        @endif
    </div>
@stop

@include('beacons.rightSide')

