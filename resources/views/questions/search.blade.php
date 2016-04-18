@extends('app')
@section('siteTitle')
    Search Questions
@stop


@section('centerText')
    <div>
        <h2>Search Questions</h2>
        {!! Form::open(['url' => 'questions/results', 'method' => 'GET']) !!}
        <div class = "formInput">
            <b>Question:</b>
        </div>
        <div class = "formInput">
            {!! Form::text('title', null, ['class' => 'createTitleText', 'autofocus']) !!}
        </div>
        <div class = "formInput">
            {!! Form::submit('Search', ['class' => 'navButton']) !!}
            {!! Form:: close() !!}
        </div>
    </div>
@stop
@section('centerFooter')
            <a href="{{ url('/questions/') }}"><button type = "button" class = "navButton">Recent Questions</button></a>
            <a href="{{ url('/search') }}"><button type = "button" class = "navButton">Global Search</button></a>
@stop


