@extends('app')
@section('siteTitle')
    Users
@stop

@section('centerText')
    <h2>User Directory</h2>
    <div class = "indexNav">
        <a href={{ url('/users/elevation')}}><button type = "button" class = "indexButton">Elevated</button></a>
        <a href={{ url('/users/search')}}><button type = "button" class = "indexButton">Search</button></a>
        <a href={{ url('/users')}}><button type = "button" class = "indexButton">Recent</button></a>
        <p>(Most Extended)</p>
    </div>
    <div class = "indexLeft">
        <h4>Handle</h4>
    </div>
    <div class = "indexRight">
        <h4>Extension</h4>
    </div>
    @foreach ($users as $User)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('UserController@show', [$User->id])}}"><button type = "button" class = "interactButtonLeft">{{ $User->handle }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('UserController@extendedBy', [$User->id])}}"><button type = "button" class = "interactButton">{{ $User->extension }}</button></a>
            </div>
        </div>
    @endforeach
@stop
@section('centerFooter')
    {!! $users->render() !!}
@stop


