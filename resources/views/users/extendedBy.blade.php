@extends('app')
@section('siteTitle')
    Extended By
@stop

@section('centerText')
    <div>
        <h2>Extended from <a href={{ url('/users/'.$user->id)}}>{{$user->handle}}</a></h2>
        <table style="display: inline-block;">
            <tr>
                <td><a href={{ url('/users/elevatedBy/'. $user->id)}}>Elevations</a></td>
                <td><a href={{ url('/users/'.$user->id)}}>Profile</a></td>
                <td><a href={{ url('/users/beacons/'. $user->id)}}>Beacons</a></td>
            </tr>
        </table>
    </div>
    <div style = "width: 50%; float: left;">
        <h4>Extension</h4>
    </div>
    <div style = "width: 50%; float: right;">
        <h4>Handle</h4>
    </div>
    @foreach ($extensions as $extension)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('QuestionController@show', [$extension->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $extension->title }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('UserController@show', [$extension->user->id])}}"><button type = "button" class = "interactButton">{{ $extension->user->handle}}</button></a>
            </div>
        </div>
    @endforeach

@stop
@section('centerFooter')
    {!! $extensions->render() !!}
@stop