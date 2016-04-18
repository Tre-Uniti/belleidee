@extends('app')
@section('siteTitle')
    Users
@stop

@section('centerText')
    <h2>User Directory</h2>
        <div class = "indexNav">
            <a href={{ url('/users')}}><button type = "button" class = "indexButton">Most Recent</button></a>
            <a href={{ url('/users/search')}}><button type = "button" class = "indexButton">Search</button></a>
            <a href={{ url('/users/sortByExtension')}}><button type = "button" class = "indexButton">Most Extended</button></a>
            <p>(Top Elevated)</p>
        </div>
    <div class = "indexLeft">
        <h4>Handle</h4>
    </div>
    <div class = "indexRight">
        <h4>Joined</h4>
    </div>
    @foreach ($users as $user2)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('UserController@show', [$user2->id])}}"><button type = "button" class = "interactButtonLeft">{{ $user2->handle }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('UserController@show', [$user2->id])}}"><button type = "button" class = "interactButton">{{ $user2->created_at->format('M-d-Y') }}</button></a>
            </div>
        </div>
    @endforeach
@stop
@section('centerFooter')
    {!! $users->render() !!}
@stop


