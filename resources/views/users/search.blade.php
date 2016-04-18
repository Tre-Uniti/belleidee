@extends('app')
@section('siteTitle')
    Search Users
@stop


@section('centerText')
    <div>
        <h2>Search Users</h2>
        {!! Form::open(['url' => 'users/results', 'method' => 'GET']) !!}
            <div class = "formInput">
                <b>Handle:</b>
            </div>
            <div class = "indexNav">
                {!! Form::text('identifier', null, ['class' => 'createTitleText', 'autofocus']) !!}
            </div>
            <div class = "formInput">
                {!! Form::submit('Search', ['class' => 'navButton']) !!}
                {!! Form:: close() !!}
            </div>
    </div>
@stop
@section('centerFooter')
            <a href="{{ url('/users/') }}"><button type = "button" class = "navButton">Recent Users</button></a>
            <a href="{{ url('/search') }}"><button type = "button" class = "navButton">Global Search</button></a>
@stop


