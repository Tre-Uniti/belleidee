@extends('app')
@section('siteTitle')
    Show Promotion
@stop

@section('centerText')
    <h2>Promo: {{ $promotion->promo }}</h2>

    <div class = "formLabel">
        Status:
    </div>
    <div class = "formShowData">
        {{ $promotion->status }}
    </div>
    <div class = "formLabel">
        Created:
    </div>
    <div class = "formShowData">
        {{ $promotion->created_at->format('M-d-Y') }}
    </div>
    <div class = "formLabel">
        Sponsor:
    </div>
    <div class = "formShowData">
        <a href = "{{ url('/sponsors/'. $promotion->sponsor_id) }}">{{ $promotion->sponsor->name }}</a>
    </div>
    <div id = "centerTextContent">
        <p>{!! nl2br($promotion->description) !!}</p>
    </div>

@stop

@section('centerFooter')
    @if($user->type > 1 || $user->id == $promotion->sponsor_id)
        <a href="{{ url('/sponsors/eligible/'. $promotion->sponsor_id) }}"><button type = "button" class = "navButton">Eligible Users</button></a>
    @endif
    @if($user->type > 1)
        <a href="{{ url('/promotions/'.$promotion->id .'/edit')}}"><button type = "button" class = "navButton">Edit</button></a>
    @endif
@stop