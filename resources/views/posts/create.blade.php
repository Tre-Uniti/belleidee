@extends('app')
@section('siteTitle')
    Create
@stop
@section('handle')
    {{Auth::user()->handle}}
@stop
@section('centerMenu')
    @if (count($errors) > 0)
        @include('errors.list')
    @endif
@stop
@section('centerText')
    <h2>Create Inspiration</h2>

    {!! Form::open(['url' => 'posts']) !!}
    @include ('posts._form', ['submitButtonText' => 'Post Inspiration'])
    {!! Form::close()   !!}


    @include ('errors.list')
@stop
@section('centerFooter')
    <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Save as draft</button></a>
    <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Show Sources</button></a>
    <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Check Sponsor</button></a>
@stop