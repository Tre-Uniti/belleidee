@extends('app')
@section('siteTitle')
    Admin Portal
@stop
@section('centerText')
    <h2>Admin Portal</h2>
    <table align = 'center'>
        <tr>
            <td><a href="{{ url('adjudications') }}"><button type = "button" class = "navButton">Adjudications</button></a></td>
            <td><a href="{{ url('moderations') }}"><button type = "button" class = "navButton">Moderations</button></a></td>
            <td><a href="{{ url('intolerances') }}"><button type = "button" class = "navButton">Intolerances</button></a></td>
        </tr>
        <tr>
            <td><a href="{{ url('questions/create') }}"><button type = "button" class = "navButton">Questions</button></a></td>
            <td><a href="{{ url('/admin/beacon/requests') }}"><button type = "button" class = "navButton">Beacons</button></a></td>
            <td><a href="{{ url('/admin/sponsor/requests') }}"><button type = "button" class = "navButton">Sponsors</button></a></td>
        </tr>
    </table>
    <div style = "width: 50%; float: left;">
        <h4>Admins</h4>
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


