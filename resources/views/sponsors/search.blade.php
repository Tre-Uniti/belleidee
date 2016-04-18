@extends('app')
@section('siteTitle')
    Search Sponsors
@stop

@section('centerText')
    <h2>Search Sponsors</h2>
        {!! Form::open(['url' => 'sponsors/results', 'method' => 'GET']) !!}
        <div class = "formInput">
            {!! Form::select('type', $types) !!}
        </div>
        <div class = "indexNav">
            {!! Form::text('identifier', null, ['class' => 'createTitleText', 'autofocus']) !!}
        </div>
        <div class = "formInput">
        {!! Form::submit('Search', ['class' => 'navButton']) !!}
        {!! Form:: close() !!}
        </div>

@stop
@section('centerFooter')
    <a href="{{ url('/sponsors/') }}"><button type = "button" class = "navButton">All Sponsors</button></a>
    <a href="{{ url('/search') }}"><button type = "button" class = "navButton">Global Search</button></a>
@stop


