@extends('app')
@section('siteTitle')
    Global Search
@stop

@section('centerText')
    <div>
        <h2>Global Search</h2>
        {!! Form::open(['url' => '/results', 'method' =>  'GET']) !!}
        <div class = "formDataContainer">
            <div class = "formInput">
                {!!  Form::label('type', 'Type:') !!}
            </div>
            <div class = "formInput">
                {!! Form::select('type', $types) !!}
            </div>
            <div class = "formInput">
                {!! Form::text('identifier', null, ['placeholder' => 'Search text']) !!}
            </div>
            <p>Location Scope: {{ $location }}</p>
        </div>

        {!! Form::submit('Search', ['class' => 'navButton']) !!}
        {!! Form:: close() !!}
    </div>
@stop



