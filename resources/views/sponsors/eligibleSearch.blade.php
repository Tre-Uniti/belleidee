@extends('app')
@section('siteTitle')
    Eligible Sponsorships
@stop

@section('centerText')

    <h2>{{ $sponsor->name }} Eligible Sponsorships</h2>

    <div class = "indexNav">
        <a href="{{ url('/sponsors/'. $sponsor->id) }}"><button type = "button" class = "indexButton">About</button></a>
        <a href = "{{ $location }}" target = "_blank"><button type = "button" class = "indexButton">Location</button></a>
        <a href="{{ $sponsor->website }}" target="_blank"><button type = "button" class = "indexButton">Website</button></a>
    </div>
    <div class = "indexNav">
        <a href="{{ url('/sponsors/eligible/'. $sponsor->id) }}"><button type = "button" class = "indexButton">Total Eligible: {{ $eligibleCount }}</button></a>
        <a href="{{ url('/sponsors/sponsorships/'. $sponsor->id) }}"><button type = "button" class = "indexButton">All Sponsorships</button></a>
    </div>
    <div class = "formDataContainer">
        {!! Form::open(['url' => 'sponsors/eligibleResults', 'method' => 'GET']) !!}
        <div class = "formInput">
            {!!  Form::label('handle', 'Handle:') !!}
        </div>
        <div class = "formInput">
            {!! Form::text('handle', null, ['placeholder' => 'Search text']) !!}
        </div>
        {!! Form::hidden('sponsorId', $sponsor->id) !!}
    </div>
    {!! Form::submit('Search', ['class' => 'navButton']) !!}

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $sponsorships])
@stop


