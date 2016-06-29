@extends('app')
@section('siteTitle')
    Admin Portal
@stop
@section('centerText')
    <h2>Admin Portal</h2>
    <div class = "indexNav">
        <a href="{{ url('adjudications') }}"><button type = "button" class = "indexButton">Adjudications</button></a>
        <a href="{{ url('moderations') }}"><button type = "button" class = "indexButton">Moderations</button></a>
        <a href="{{ url('intolerances') }}"><button type = "button" class = "indexButton">Intolerances</button></a>
        </div>
    <div class = "indexNav">
        <a href="{{ url('/legacies') }}"><button type = "button" class = "indexButton">Legacies</button></a>
        <a href="{{ url('/questions/create') }}"><button type = "button" class = "indexButton">Questions</button></a>
        <a href="{{ url('/admin/beacon/requests') }}"><button type = "button" class = "indexButton">Beacons</button></a>
        <a href="{{ url('/admin/sponsor/requests') }}"><button type = "button" class = "indexButton">Sponsors</button></a>
    </div>
    <div class = "indexLeft">
        <h4>Admins</h4>
    </div>
    <div class = "indexRight">
        <h4>Joined</h4>
    </div>

    @foreach ($admins as $admin)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('UserController@show', [$admin->id])}}"><button type = "button" class = "interactButton">{{ $admin->handle }}</button></a>
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


