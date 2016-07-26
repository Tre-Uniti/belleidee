@extends('app')
@section('siteTitle')
    Sponsorships
@stop

@section('centerText')

    <h2>{{ $sponsor->name }} Sponsorships</h2>

    <div class = "indexNav">
        <a href="{{ url('/sponsors/'. $sponsor->sponsor_tag) }}"><button type = "button" class = "indexButton">Sponsor Profile</button></a>
        <a href = "{{ $location }}" target = "_blank"><button type = "button" class = "indexButton">Location</button></a>
        <a href="{{ $sponsor->website }}" target="_blank"><button type = "button" class = "indexButton">Website</button></a>
    </div>
    <div class = "indexNav">
        <button type = "button" class = "indexButton">Total: {{ $sponsor->sponsorships }}</button>
        @if($user->id == $sponsor->user_id || $user->type > 1 )
        <a href="{{ url('/sponsors/eligible/'. $sponsor->id) }}"><button type = "button" class = "indexButton">Promo Eligible</button></a>
        @endif
    </div>

    <div class = "indexLeft">
        <h4>Handle</h4>
    </div>
    <div class = "indexRight">
        <h4>Start Date</h4>
    </div>
    @foreach ($sponsorships as $sponsorship)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('UserController@show', [$sponsorship->user_id])}}"><button type = "button" class = "interactButtonLeft">{{ $sponsorship->user->handle }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('SponsorController@show', [$sponsorship->sponsor->sponsor_tag])}}"><button type = "button" class = "interactButton">{{ $sponsorship->created_at->format('M-d-Y')}}</button></a>
            </div>
        </div>
    @endforeach

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $sponsorships])
    <div>
        <a href="{{ url('promotions/sponsor/'.$sponsor->id) }}"><button type = "button" class = "navButton">View All Promos</button></a>
    </div>
@stop


