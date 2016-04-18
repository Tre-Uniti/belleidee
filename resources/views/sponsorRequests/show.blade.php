@extends('app')
@section('siteTitle')
    Sponsor Request
@stop

@section('centerMenu')
    <h2>{{ $sponsorRequest->name }}</h2>
@stop

@section('centerText')
    <div class = "formInput">
        <b>Address:</b>
        {{ $sponsorRequest->address }}
    </div>
    <div class = "formInput">
        <b>Country:</b>
        {{ $sponsorRequest->country }}
    </div>
    <div class = "formInput">
        <b>City or Region:</b>
        {{ $sponsorRequest->location }}
    </div>
    <div class = "formInput">
        <b>Phone:</b>
        {{ $sponsorRequest->phone }}
    </div>
    <div class = "formInput">
        <b>Email:</b>
        {{ $sponsorRequest->email }}
    </div>
    <div class = "formInput">
        <b>Website:</b>
        {{ $sponsorRequest->website }}
    </div>
    <div class = "formInput">
        <b>Adult:</b>  {{ $sponsorRequest->adult }}
    </div>
@stop

@section('centerFooter')
    <div id = "centerFooter">
        <a href="{{ url('/sponsorRequests/') }}"><button type = "button" class = "navButton">Requests</button></a>
        @if($sponsorRequest->user_id == $user->id)
            <a href="{{ url('/sponsorRequests/'.$sponsorRequest->id .'/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
        @endif
        @if($user->type > 1)
                <a href="{{ url('/admin/sponsor/review/'.$sponsorRequest->id) }}"><button type = "button" class = "navButton">Review</button></a>
        @endif
    </div>
@stop

