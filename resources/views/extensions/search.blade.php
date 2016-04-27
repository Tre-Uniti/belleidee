@extends('app')
@section('siteTitle')
    Search Extensions
@stop

@section('centerText')
    <div>
        <h2>Search Extensions</h2>
        {!! Form::open(['url' => 'extensions/results', 'method' => 'GET']) !!}
        <div class = "formDataContainer">
            <div class = "formInput">
                {!!  Form::label('identifier', 'Title:') !!}
            </div>
            <div class = "formInput">
                {!! Form::text('title', null, ['class' => 'createTitleText', 'autofocus', 'placeholder' => 'Search text']) !!}
            </div>
        </div>
        {!! Form::submit('Search', ['class' => 'navButton']) !!}
        {!! Form:: close() !!}
    </div>
@stop
@section('centerFooter')
            <a href="{{ url('/extensions/') }}"><button type = "button" class = "navButton">Recent Extensions</button></a>
            <a href="{{ url('/search') }}"><button type = "button" class = "navButton">Global Search</button></a>
@stop


