@extends('app')
@section('siteTitle')
    Show Sponsor
@stop

@section('centerText')
    <h2>{{ $sponsor->name }}</h2>
        <div class = "indexNav">
            <a href="{{ url('/sponsors/sponsorships/'. $sponsor->id) }}"><button type = "button" class = "indexButton">Sponsorships</button></a>
            <a href = "{{ $location }}" target = "_blank"><button type = "button" class = "indexButton">Location</button></a>
            <a href="{{ $sponsor->website }}" target="_blank"><button type = "button" class = "indexButton">Website</button></a>
        </div>
        @if($user->type > 1 || $user->id == $sponsor->user_id)
            <div>
                <a href="{{ url('promotions/create/'. $sponsor->id) }}"> <button type = "button" class = "indexButton">Create Promotion</button></a>
                <button type = "button" class = "indexButton">Views: {{ $sponsor->views }} / {{ $sponsor->view_budget }}</button>
                <button type = "button" class = "indexButton">Clicks: {{ $sponsor->clicks }} / {{ $sponsor->click_budget }}</button>
            </div>
        @endif

    <h4>Sponsor Promotions for: {{ $sponsor->sponsor_tag }}</h4>
        <div class = "indexLeft">
            <h4>Status</h4>
        </div>
        <div class = "indexRight">
            <h4>Created At</h4>
        </div>
    @foreach($promotions as $promotion)
        @if($promotion->status == 'Eligible Only')
            @if($user->type > 1 || $user->id == $sponsor->user_id || $eligibleUser == 'yes')
                <div class = "listResource">
                <div class = "indexLeft">
                    <a href="{{ action('PromotionController@show', [$promotion->id])}}"><button type = "button" class = "interactButtonLeft">{{ $promotion->status }}</button></a>
                </div>
                <div class = "listResourceRight">
                     <a href="{{ action('PromotionController@show', [$promotion->id])}}"><button type = "button" class = "interactButton">{{ $promotion->created_at->format('M-d-Y')}}</button></a>
                </div>
                </div>
             @endif
        @elseif($promotion->status == 'Open to All')
            <div class = "listResource">
                <div class = "indexLeft">
                    <a href="{{ action('PromotionController@show', [$promotion->id])}}"><button type = "button" class = "interactButtonLeft">{{ $promotion->status }}</button></a>
                </div>
                <div class = "listResourceRight">
                    <a href="{{ action('PromotionController@show', [$promotion->id])}}"><button type = "button" class = "interactButton">{{ $promotion->created_at->format('M-d-Y')}}</button></a>
                </div>
            </div>
            @endif
    @endforeach
@stop

@section('centerFooter')
    @if($user->type > 1 || $user->id == $sponsor->user_id)
        <a href="{{ url('/sponsors/pay/'. $sponsor->id) }}"><button type = "button" class = "navButton">Pay</button></a>
    @endif
    @if($user->type > 1)
        <a href="{{ url('/sponsors/'.$sponsor->id .'/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
    @endif
    @if($eligibleUser != NULL)
        <a href="{{ url('promotions/sponsor/'.$sponsor->id) }}"><button type = "button" class = "navButton">View All Promos</button></a>
    @else
        <a href="{{ url('/sponsors/sponsorship/'.$sponsor->id) }}"><button type = "button" class = "navButton">Start Sponsorship</button></a>
    @endif

@stop

