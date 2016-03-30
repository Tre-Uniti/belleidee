@extends('app')
@section('siteTitle')
    Elevation of Extension
@stop

@section('centerText')
    <div>
        <h2>Elevations of  <a href={{ url('/extensions/'. $extension->id)}}>{{ $extension->title }}</a></h2>

    </div>
    <div style = "width: 50%; float: left;">
        <h4>Date</h4>
    </div>
    <div style = "width: 50%; float: right;">
        <h4>Elevated By</h4>
    </div>

    @foreach ($elevations as $elevate)

        <div class = "listResource">
            <div class = "listResourceLeft" style = "padding-left: 0; text-align: center; width: 50%;">
                <a href="{{ action('ExtensionController@show', [$extension->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $elevate->created_at->format('M-d-Y') }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('UserController@show', [$elevate->user_id])}}"><button type = "button" class = "interactButton">{{ $elevate->user->handle }}</button></a>
            </div>
        </div>
    @endforeach

@stop
@section('centerFooter')
    {!! $elevations->render() !!}
@stop



