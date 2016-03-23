@extends('app')
@section('siteTitle')
    Beacon Review
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
            <tr>
                <td><b>User:</b></td>
                <td>{{ $beaconRequest->user->handle }}</td>
            </tr>
        </table>
    </div>
@stop

@section('centerFooter')
    <div id = "centerFooter">
        @if($user->type > 1)
            <a href="{{ url('/admin/beacon/convert/'.$beaconRequest->id) }}"><button type = "button" class = "navButton">Convert to Beacon</button></a>
                {!! Form::open(['method' => 'DELETE', 'route' => ['beaconRequests.destroy', $beaconRequest->id]]) !!}
                {!! Form::submit('Delete', ['class' => 'navButton', 'id' => 'delete']) !!}
                {!! Form::close() !!}

        @endif
    </div>
@stop

