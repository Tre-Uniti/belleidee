@extends('app')
@section('siteTitle')
    Elevated Posts
@stop

@section('centerText')
    <h2>{{ $location }} Open Promotions</h2>
    <div class = "indexNav">
        <a href={{ url('/sponsors/'. $sponsor->sponsor_tag)}}><button type = "button" class = "indexButton">Your Sponsor</button></a>
        <a href={{ url('/promotions/sponsor/'. $sponsor->id)}}><button type = "button" class = "indexButton">Eligible Promotions</button></a>
    </div>

    <hr class = "contentSeparator"/>
    @include('promotions._promotionCards')
@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $promotions])

@stop