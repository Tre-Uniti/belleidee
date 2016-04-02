@extends('app')
@section('siteTitle')
    Moderation Portal
@stop
@section('centerText')
    <h2>Moderation Portal</h2>
    <a href="{{ url('intolerances') }}"><button type = "button" class = "navButton">Intolerance</button></a>
    <hr/>
    <div style = "width: 50%; float: left;">
        <h4>Moderators</h4>
    </div>
    <div style = "width: 50%; float: right;">
        <h4>Joined</h4>
    </div>

    @foreach ($moderators as $moderator)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('UserController@show', [$moderator->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $moderator->handle }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('UserController@show', [$moderator->id])}}"><button type = "button" class = "interactButton">{{ $moderator->created_at->format('M-d-Y') }}</button></a>
            </div>
        </div>
    @endforeach

@stop
@section('centerFooter')
    {!! $moderators->render() !!}
@stop


