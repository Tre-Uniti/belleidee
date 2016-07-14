@extends('app')
@section('siteTitle')
    Search Legacy
@stop
@section('centerText')
    <h2>Search Legacy Posts</h2>

        <div class = "formDataContainer">
            {!! Form::open(['url' => 'legacyPosts/results', 'method' => 'GET']) !!}
            <div class = "formData">
                <div class = "formInput">
                    {!! Form::label('belief', 'Belief:') !!}
                </div>
                <div class = "formInput">
                    {!! Form::select('belief', $beliefs) !!}
                </div>
            </div>
            <div class = "formInput">
                {!!  Form::label('identifier', 'Title:') !!}
            </div>
            <div class = "formInput">
                {!! Form::text('title', null, ['autofocus', 'placeholder' => 'Search title']) !!}
            </div>
        </div>
        {!! Form::submit('Search', ['class' => 'navButton']) !!}
        {!! Form:: close() !!}
@stop
@section('centerFooter')
    <a href="{{ url('/posts/') }}"><button type = "button" class = "navButton">Recent Legacy</button></a>
    <a href="{{ url('/search') }}"><button type = "button" class = "navButton">Global Search</button></a>
@stop


