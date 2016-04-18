@extends('app')
@section('siteTitle')
    Search Posts
@stop
@section('centerText')
    <h2>Search Posts</h2>
    <div class = "formInput">
        {!! Form::open(['url' => 'posts/results', 'method' => 'GET']) !!}
        <b>Title:</b>
          </div>
    <div class = "formInput">
        {!! Form::text('title', null, ['class' => 'createTitleText', 'autofocus']) !!}
        </div>
    <div class = "formInput">
        {!! Form::submit('Search', ['class' => 'navButton']) !!}
        {!! Form:: close() !!}
    </div>
@stop
@section('centerFooter')
    <a href="{{ url('/posts/') }}"><button type = "button" class = "navButton">Recent Posts</button></a>
    <a href="{{ url('/search') }}"><button type = "button" class = "navButton">Global Search</button></a>
@stop


