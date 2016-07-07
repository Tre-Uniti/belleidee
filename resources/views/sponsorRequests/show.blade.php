@extends('app')
@section('siteTitle')
    Sponsor Request
@stop

@section('centerText')
    <h2>{{ $sponsorRequest->name }}</h2>
    <div class = "formLabel">
        Address:
    </div>
    <div class = "formShowData">
        {{ $sponsorRequest->address }}
    </div>
    <div class = "formLabel">
        Country:
    </div>
    <div class = "formShowData">
        {{ $sponsorRequest->country }}
    </div>
    <div class = "formLabel">
        City:
    </div>
    <div class = "formShowData">
        {{ $sponsorRequest->city }}
    </div>
    <div class = "formLabel">
        Zip:
    </div>
    <div class = "formShowData">
        {{ $sponsorRequest->zip }}
    </div>
    <div class = "formLabel">
        Phone:
    </div>
    <div class = "formShowData">
        {{ $sponsorRequest->phone }}
    </div>
    <div class = "formLabel">
        Email:
    </div>
    <div class = "formShowData">
        {{ $sponsorRequest->email }}
    </div>
    <div class = "formLabel">
        Website:
    </div>
    <div class = "formShowData">
        {{ $sponsorRequest->website }}
    </div>
    <div class = "formLabel">
        Adult:
    </div>
    <div class = "formShowData">
        {{ $sponsorRequest->adult }}
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

