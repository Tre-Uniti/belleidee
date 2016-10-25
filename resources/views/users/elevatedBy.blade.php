@extends('app')
@section('siteTitle')
    Extended By
@stop

@section('centerText')
    <h2>Elevation of <a href={{ url('/users/'.$user->id)}}>{{$user->handle}}</a></h2>
        <div class = "indexNav">
            <a href={{ url('/users/beacons/'. $user->id)}}><button type = "button" class = "indexButton">Beacons</button></a>
            <a href={{ url('/users/'.$user->id)}}><button type = "button" class = "indexButton">Profile</button></a>
            <a href={{ url('/users/extendedBy/'. $user->id)}}><button type = "button" class = "indexButton">Extended By</button></a>
    </div>
<hr class = "contentSeparator"/>
    @include('elevations._userElevationCards')

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $elevations])
@stop