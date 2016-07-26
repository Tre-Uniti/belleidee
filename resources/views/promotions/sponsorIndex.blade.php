@extends('app')
@section('siteTitle')
    Elevated Posts
@stop

@section('centerText')
    <h2>Promotions for {{ $sponsor->name }}</h2>
    <div class = "indexNav">
        <a href={{ url('/sponsors/'. $sponsor->sponsor_tag)}}><button type = "button" class = "indexButton">About</button></a>
        <a href={{ url('/sponsors/sponsorships/'. $sponsor->id)}}><button type = "button" class = "indexButton">Sponsorships</button></a>
        @if($user->type > 1 || $user->id == $sponsor->user_id)
        <a href={{ url('/sponsors/eligible/'. $sponsor->id)}}><button type = "button" class = "indexButton">Promo Eligible</button></a>
        @endif
    </div>
    <div class = "indexLeft">
        <h4>Status</h4>
    </div>
    <div class = "indexRight">
        <h4>Created At</h4>
    </div>
    @foreach ($promotions as $promotion)
        <div class = "listResource">
            <div class = "indexLeft">
                <a href="{{ action('PromotionController@show', [$promotion->id])}}"><button type = "button" class = "interactButtonLeft">{{ $promotion->status }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('PromotionController@show', [$promotion->id])}}"><button type = "button" class = "interactButton">{{ $promotion->created_at->format('M-d-Y') }}</button></a>
            </div>
        </div>
    @endforeach
@stop
@section('centerFooter')
    @if($user->id == $sponsor->user_id || $user->type > 1)
        <a href = "{{ url('/promotions/create/'. $sponsor->id) }}"><button type = "button" class = "navButton">New Promo</button></a>
    @endif
    @include('pagination.custom-paginator', ['paginator' => $promotions])
@stop