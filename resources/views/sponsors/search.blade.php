@extends('app')
@section('siteTitle')
    Search Sponsors
@stop

@section('centerText')
    <h2>Search Sponsors</h2>

    <div class = "formDataContainer">
        {!! Form::open(['url' => 'sponsors/results', 'method' => 'GET']) !!}
        <div class = "formInput">
            {!!  Form::label('identifier', 'Name:') !!}
        </div>
        <div class = "formInput">
            {!! Form::text('identifier', null, ['placeholder' => 'Search text']) !!}
        </div>
    </div>
    {!! Form::submit('Search', ['class' => 'navButton']) !!}
@stop
@section('centerFooter')
    <a href="{{ url('/sponsors/') }}"><button type = "button" class = "navButton">All Sponsors</button></a>
    <a href="{{ url('/search') }}"><button type = "button" class = "navButton">Global Search</button></a>
@stop


