@extends('app')
@section('siteTitle')
    Promotions for {{ $sponsor->name }}
@stop

@section('centerText')
    <h2>Promotions for {{ $sponsor->name }}</h2>
    <div class = "indexNav">
        <a href="{{ url('/sponsors/'. $sponsor->sponsor_tag)}}" class = "indexLink">About</a>
        <a href="{{ url('/sponsors/sponsorships/'. $sponsor->sponsor_tag)}}" class = "indexLink">Sponsorships</a>
        @if($user->type > 1 || $user->id == $sponsor->user_id)
        <a href="{{ url('/sponsors/eligible/'. $sponsor->sponsor_tag)}}" class = "indexLink">Promo Eligible</a>
        @endif
    </div>
    <hr class = "contentSeparator"/>
    @include('promotions._promotionCards')
@stop
@section('centerFooter')
    @if($user->id == $sponsor->user_id || $user->type > 1)
        <a href = "{{ url('/promotions/create/'. $sponsor->id) }}"><button type = "button" class = "navButton">New Promo</button></a>
    @endif
    @include('pagination.custom-paginator', ['paginator' => $promotions])
@stop