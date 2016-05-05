@extends('app')
@section('siteTitle')
    User Intolerances
@stop

@section('centerText')
    <h2>Intolerance for <a href = "{{ url('/beacons/tags/'. $beacon->beacon_tag) }}">{{ $beacon->beacon_tag }}</a></h2>
        <div class = "indexNav">
            <a href={{ url('/intolerances')}}><button type = "button" class = "indexButton">All Intolerances</button></a>
    </div>
    <div class = "indexLeft">
        <h4>Date</h4>
    </div>
    <div class = "indexRight">
        <h4>handle</h4>
    </div>

    @foreach ($intolerances as $intolerance)

        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('IntoleranceController@show', [$intolerance->id])}}"><button type = "button" class = "interactButton">{{ $intolerance->created_at->format('M-d-Y') }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('UserController@show', [$intolerance->user_id])}}"><button type = "button" class = "interactButton">{{ $intolerance->user->handle }}</button></a>
            </div>
        </div>
    @endforeach

@stop
@section('centerFooter')
    {!! $intolerances->render() !!}
@stop



