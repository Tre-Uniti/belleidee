@extends('app')
@section('siteTitle')
    Show Sponsor
@stop

@section('centerMenu')
    <h2>{{ $sponsor->name }}</h2>
@stop

@section('centerText')
        <div class = "indexNav">
            <a href="{{ url('/sponsors/sponsorships/'. $sponsor->id) }}"><button type = "button" class = "indexButton">Sponsorships: {{ $sponsor->sponsorships }}</button></a>
            <a href = "{{ $location }}" target = "_blank"><button type = "button" class = "indexButton">Location</button></a>
            <a href="{{ $sponsor->website }}" target="_blank"><button type = "button" class = "indexButton">Website</button></a>
        </div>
        @if($user->type > 1 || $user->id == $sponsor->user_id)
            <div class = "">
                <button type = "button" class = "indexButton">Views: {{ $sponsor->views }} / {{ $sponsor->view_budget }}</button>
                <button type = "button" class = "indexButton">Clicks: {{ $sponsor->clicks }} / {{ $sponsor->click_budget }}</button>
            </div>
        @endif

    <h4>Sponsor Promotions:</h4>
    <p>Sponsor promotions will start when there are more sponsors using Idee.</p>
    <p>You may request a new sponsor <a href = {{ url('/sponsorRequests/create') }}>here</a></p>

@stop

@section('centerFooter')
    @if($user->type > 1 || $user->id == $sponsor->user_id)
        <a href="{{ url('/sponsors/pay/'. $sponsor->id) }}"><button type = "button" class = "navButton">Pay</button></a>
    @endif
    @if($user->type > 1)
        <a href="{{ url('/sponsors/'.$sponsor->id .'/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
    @endif
        <a href="{{ url('/sponsors/sponsorship/'.$sponsor->id) }}"><button type = "button" class = "navButton">Start Sponsorship</button></a>
@stop

