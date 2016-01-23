@extends('app')
@section('siteTitle')
    Admin Portal
@stop
@section('centerText')
    <h2>Admin Portal</h2>
    <a href="{{ url('questions/create') }}"><button type = "button" class = "navButton">Questions</button></a>
    <a href="{{ url('moderations') }}"><button type = "button" class = "navButton">Moderations</button></a>
    <a href="{{ url('/') }}"><button type = "button" class = "navButton">Legacy</button></a>
    <hr/>
    <div style = "width: 50%; float: left;">
        <h4>Admin</h4>
    </div>
    <div style = "width: 50%; float: right;">
        <h4>Joined</h4>
    </div>

    @foreach ($admins as $admin)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('UserController@show', [$admin->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $admin->handle }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('UserController@show', [$admin->id])}}"><button type = "button" class = "interactButton">{{ $admin->created_at->format('M-d-Y') }}</button></a>
            </div>
        </div>
    @endforeach

@stop
@section('centerFooter')
    {!! $admins->render() !!}
@stop


