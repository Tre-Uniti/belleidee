@extends('app')
@section('siteTitle')
    Show Promotion
@stop


@section('centerText')
    <h2>{{ $promotion->status }}</h2>
    <p>{{ $promotion->description }}</p>
@stop

@section('centerFooter')
    <a href="{{ url('/beliefs/') }}"><button type = "button" class = "navButton">Belief Directory</button></a>
    @if($user->type > 1)
        <a href="{{ url('/promotions/'.$promotion->id .'/edit')}}"><button type = "button" class = "navButton">Edit</button></a>
    @endif
@stop