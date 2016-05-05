@extends('app')
@section('siteTitle')
    Beacon Subscription
@stop

@section('centerText')

    @include ('errors.list')

    <h2>Change Subscription for: {{ $beacon->name }}</h2>

    <p>Current subscription: </p>
    @if($beacon->tier == 0)
        <p>Free community:  $0/month</p>
    @elseif($beacon->tier == 1)
        <p>Small community: $25/month</p>
    @elseif($beacon->tier == 2)
        <p>Medium community: $50/month</p>
    @elseif($beacon->tier == 3)
        <p>Large community: $100/month</p>
    @endif

    Change Subscription to:

@stop