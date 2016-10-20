@extends('app')
@section('siteTitle')
    Eligible Sponsorships
@stop

@section('centerText')
    <h2><a href = "{{ url('/sponsors/'. $sponsor->sponsor_tag) }}">{{ $sponsor->name }}</a></h2>

    <div class = "indexNav">
        <a href="{{ url('/sponsors/'. $sponsor->sponsor_tag) }}" class = "indexLink">Profile</a>
        <a href="{{ url('/sponsors/contact' . $sponsor->sponsor_tag) }}" class = "indexLink">Contact</a>
    </div>
    <p>Eligible Users: <a href = "{{ url('/sponsors/' . $sponsor->sponsor_tag) }}" class = "contentHandle">{{ $sponsor->sponsor_tag }}</a></p>

    <div class = "indexNav">
        <a href="{{ url('/sponsors/eligibleSearch/'. $sponsor->sponsor_tag) }}" class = "indexLink">Search Eligible</a>
        <a href="{{ url('/sponsors/sponsorships/'. $sponsor->sponsor_tag) }}" class = "indexLink">All Sponsorships</a>
    </div>

    <div class = "contentHeaderSeparator">
        <h3>Search Results </h3>
    </div>
    @include('sponsors._sponsorshipCards')

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $sponsorships])
@stop


