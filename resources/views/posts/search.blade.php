@extends('app')
@section('siteTitle')
    Search Posts
@stop
@section('centerText')
    <h2>Search Posts</h2>

        <div class = "formDataContainer">
            {!! Form::open(['url' => 'posts/results', 'method' => 'GET']) !!}
            <div class = "formInput">
                {!!  Form::label('identifier', 'Title:') !!}
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
    <a href="{{ url('/posts/') }}"><button type = "button" class = "navButton">Recent Posts</button></a>
    <a href="{{ url('/search') }}"><button type = "button" class = "navButton">Global Search</button></a>
@stop


