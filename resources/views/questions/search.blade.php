@extends('app')
@section('siteTitle')
    Search Questions
@stop


@section('centerText')
    <h2>Search Questions</h2>
    <div class = "formDataContainer">
        {!! Form::open(['url' => 'questions/results', 'method' => 'GET']) !!}
        <div class = "formInput">
            {!!  Form::label('title', 'Question:') !!}
        </div>
        <div class = "formInput">
            {!! Form::text('title', null, ['autofocus', 'placeholder' => 'Search text']) !!}
        </div>
        <p>Location Scope: {{ $location }}</p>
    </div>
    {!! Form::submit('Search', ['class' => 'navButton']) !!}
    {!! Form:: close() !!}
@stop
@section('centerFooter')
    <a href="{{ url('/questions/') }}"><button type = "button" class = "navButton">Recent Questions</button></a>
    <a href="{{ url('/search') }}"><button type = "button" class = "navButton">Global Search</button></a>
@stop


