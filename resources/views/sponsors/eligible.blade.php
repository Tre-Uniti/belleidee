@extends('app')
@section('siteTitle')
    Eligible Sponsorships
@stop

@section('centerText')

    <h2><a href = "{{ url('/sponsors/'. $sponsor->sponsor_tag) }}">{{ $sponsor->name }}</a></h2>

    <div class = "indexNav">
        <a href="{{ url('/sponsors/'. $sponsor->sponsor_tag) }}"><button type = "button" class = "indexButton">Sponsor Profile</button></a>
        <a href="{{ $sponsor->website }}" target="_blank"><button type = "button" class = "indexButton">Website</button></a>
    </div>
    <p>Users sponsored by: <a href = "{{ url('/sponsors/' . $sponsor->sponsor_tag) }}" class = "contentHandle">{{ $sponsor->sponsor_tag }}</a></p>
    <div class = "indexNav">
        <a href="{{ url('/sponsors/eligibleSearch/'. $sponsor->sponsor_tag) }}"><button type = "button" class = "indexButton">Search Eligible</button></a>
        <a href="{{ url('/sponsors/sponsorships/'. $sponsor->sponsor_tag) }}"><button type = "button" class = "indexButton">All Sponsorships</button></a>
    </div>

    <div class = "contentHeaderSeparator">
        <h3>Eligible Users ( {{ $eligibleCount}}@if($eligibleCount == 10)+  @endif ) </h3>
    </div>
    @include('sponsors._sponsorshipCards')

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $sponsorships])
@stop


