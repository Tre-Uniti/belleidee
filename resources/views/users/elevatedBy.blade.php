@extends('app')
@section('siteTitle')
    Extended By
@stop

@section('centerText')
    <div>
        <h2>Elevation of <a href={{ url('/users/'.$user->id)}}>{{$user->handle}}</a></h2>
        <table style="display: inline-block;">
            <tr>
                <td><a href={{ url('/users/beacons/'. $user->id)}}>Beacons</a></td>
                <td><a href={{ url('/users/'.$user->id)}}>Profile</a></td>
                <td><a href={{ url('/users/extendedBy/'. $user->id)}}>Extensions</a></td>
            </tr>
        </table>
    </div>
    <div style = "width: 50%; float: left;">
        <h4>Post or Extension</h4>
    </div>
    <div style = "width: 50%; float: right;">
        <h4>Elevated By</h4>
    </div>
    @foreach ($elevations as $elevation)
        <div class = "listResource">
            <div class = "listResourceLeft">
                @if (isset($elevation->post_id))
                    <a href="{{ action('PostController@show', [$elevation->post_id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $elevation->post->title }}</button></a>
                @elseif (isset($elevation->extension_id))
                    <a href="{{ action('ExtensionController@show', [$elevation->extension_id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $elevation->extension->title }}</button></a>
                @endif
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('UserController@show', [$elevation->user_id])}}"><button type = "button" class = "interactButton">{{ $elevation->user->handle }}</button></a>
            </div>
        </div>
    @endforeach

@stop
@section('centerFooter')
    {!! $elevations->render() !!}
@stop