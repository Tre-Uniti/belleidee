@extends('app')
@section('siteTitle')
    Sponsorships
@stop

@section('centerText')
    <h2><a href = "{{ url('/sponsors/'. $sponsor->sponsor_tag) }}">{{ $sponsor->name }}</a></h2>

    <div class = "indexNav">
        <a href="{{ url('/sponsors/'. $sponsor->sponsor_tag) }}" class = "indexLink">Profile</a>
        <a href="{{ url('/sponsors/contact' . $sponsor->sponsor_tag) }}" class = "indexLink">Contact</a>
    </div>
    <p>Users sponsored by: <a href = "{{ url('/sponsors/' . $sponsor->sponsor_tag) }}" class = "contentHandle">{{ $sponsor->sponsor_tag }}</a></p>

    <div class = "indexNav">
        @if($user->id == $sponsor->user_id || $user->type > 1 )
        <a href="{{ url('/sponsors/eligible/'. $sponsor->sponsor_tag) }}" class = "indexLink">Promo Eligible</a>
        @endif
    </div>
    <hr class = "contentSeparator"/>
    @include('sponsors._sponsorshipCards')

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $sponsorships])
    <div>
        <a href="{{ url('promotions/sponsor/'.$sponsor->id) }}"><button type = "button" class = "navButton">View All Promos</button></a>
    </div>
@stop


