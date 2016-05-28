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
    <div class = "indexLeft">
        <h4>Extension</h4>
    </div>
    <div class = "indexRight">
        <h4>Extended By</h4>
    </div>
    @foreach ($extensions as $extension)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('ExtensionController@show', [$extension->id])}}"><button type = "button" class = "interactButtonLeft">{{ $extension->title }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('UserController@show', [$extension->user->id])}}"><button type = "button" class = "interactButton">{{ $extension->user->handle}}</button></a>
            </div>
        </div>
    @endforeach

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $extensions])
@stop