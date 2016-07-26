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
    <div class = "indexLeft">
        <h4>Sponsor</h4>
    </div>
    <div class = "indexRight">
        <h4>Created</h4>
    </div>
    @foreach ($promotions as $promotion)
        <div class = "listResource">
            <div class = "indexLeft">
                <a href="{{ action('PromotionController@show', [$promotion->id])}}"><button type = "button" class = "interactButtonLeft">{{ $promotion->sponsor->name }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('PromotionController@show', [$promotion->id])}}"><button type = "button" class = "interactButton">{{ $promotion->created_at->format('M-d-Y') }}</button></a>
            </div>
        </div>
    @endforeach
@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $promotions])

@stop