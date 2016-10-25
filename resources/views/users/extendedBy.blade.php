@extends('app')
@section('siteTitle')
    Extended By
@stop

@section('centerText')
        <h2>Extended from <a href={{ url('/users/'.$user->id)}}>{{$user->handle}}</a></h2>
        <div class = "indexNav">
             <a href={{ url('/users/elevatedBy/'. $user->id)}}><button type = "button" class = "indexButton">Elevated By</button></a>
             <a href={{ url('/users/'.$user->id)}}><button type = "button" class = "indexButton">Profile</button></a>
             <a href={{ url('/users/beacons/'. $user->id)}}><button type = "button" class = "indexButton">Beacons</button></a>

    </div>
<hr class = "contentSeparator"/>
    @include('extensions._extensionCards')

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $extensions])
@stop