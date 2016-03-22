@extends('app')
@section('siteTitle')
    Beacon Request
@stop

@section('centerMenu')
    <h2>{{ $beaconRequest->name }}</h2>
@stop

@section('centerText')
    <div>
        <table style="display: inline-block;">
            <tr>
                <td><b>Belief: </b></td>
                <td>{{ $beaconRequest->belief }}</td>
            </tr>
            <tr>
                <td><b>Address: </b></td>
                <td>{{ $beaconRequest->address }}</td>
            </tr>
            <tr>
                <td><b>Country:</b> </td>
                <td>{{ $beaconRequest->country }}</td>
            </tr>
            <tr>
                <td><b>City or Region:</b> </td>
                <td>{{ $beaconRequest->location }}</td>
            </tr>
            <tr>
                <td><b>Phone:</b> </td>
                <td>{{ $beaconRequest->phone }}</td>
            <tr>
                <td><b>Email:</b> </td>
                <td>{{ $beaconRequest->email }}</td>
            </tr>
            <tr>
                <td><b>Website:</b> </td>
                <td>{{ $beaconRequest->website }}</td>
            </tr>
    </table>
        </div>
@stop

@section('centerFooter')
    <div id = "centerFooter">
        <a href="{{ url('/beaconRequests/') }}"><button type = "button" class = "navButton">Requests</button></a>
        @if($beaconRequest->user_id == $user->id)
            <a href="{{ url('/beaconRequests/'.$beaconRequest->id .'/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
        @endif
        @if($user->type > 1)
                <a href="{{ url('/admin/beacon/review/'.$beaconRequest->id) }}"><button type = "button" class = "navButton">Review</button></a>
        @endif
    </div>
@stop

