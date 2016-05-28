@extends('app')
@section('siteTitle')
    User Moderations
@stop

@section('centerText')
    <h2>Moderation by {{ $user->handle }}</h2>
    <div class = "indexNav">
        <a href={{ url('/moderations')}}><button type = "button" class = "indexButton">All Moderations</button></a>
    </div>
    <div class = "indexLeft">
        <h4>Date</h4>
    </div>
    <div class = "indexRight">
        <h4>handle</h4>
    </div>

    @foreach ($moderations as $moderation)

        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('ModerationController@show', [$moderation->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $moderation->created_at->format('M-d-Y') }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('UserController@show', [$moderation->user_id])}}"><button type = "button" class = "interactButton">{{ $moderation->user->handle }}</button></a>
            </div>
        </div>
    @endforeach

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $moderations])
@stop



