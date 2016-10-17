@extends('app')
@section('siteTitle')
    Eligible Sponsorships
@stop

@section('centerText')
    <h2><a href = "{{ url('/sponsors/'. $sponsor->sponsor_tag) }}">{{ $sponsor->name }}</a></h2>

    <div class = "indexNav">
        <a href="{{ url('/sponsors/'. $sponsor->sponsor_tag) }}" class = "indexLink">Profile</a>
        <a href="{{ url('/sponsors/contact/' . $sponsor->sponsor_tag) }}" class = "indexLink">Contact</a>
    </div>
    <p>Search Eligible Users for: <a href = "{{ url('/sponsors/' . $sponsor->sponsor_tag) }}" class = "contentHandle">{{ $sponsor->sponsor_tag }}</a></p>

    <div class = "formDataContainer">
        {!! Form::open(['url' => 'sponsors/eligibleResults', 'method' => 'GET']) !!}
        <div class = "formInput">
            {!!  Form::label('handle', 'Username:') !!}
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


