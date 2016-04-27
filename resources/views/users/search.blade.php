@extends('app')
@section('siteTitle')
    Search Users
@stop


@section('centerText')
    <h2>Search Users</h2>
        <div class = "formDataContainer">
            {!! Form::open(['url' => 'users/results', 'method' => 'GET']) !!}
            <div class = "formInput">
                {!!  Form::label('identifier', 'Handle:') !!}
            </div>
            <div class = "formInput">
                {!! Form::text('identifier', null, ['class' => 'createTitleText', 'autofocus', 'placeholder' => 'Search text']) !!}
            </div>
        </div>
        {!! Form::submit('Search', ['class' => 'navButton']) !!}
        {!! Form:: close() !!}

@stop
@section('centerFooter')
    <a href="{{ url('/users/') }}"><button type = "button" class = "navButton">Recent Users</button></a>
    <a href="{{ url('/search') }}"><button type = "button" class = "navButton">Global Search</button></a>
@stop


