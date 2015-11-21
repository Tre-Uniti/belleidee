@extends('app')
@section('siteTitle')
    Create
@stop

@include('extensions.leftSide')

@section('centerText')
    <h2>Create Extension</h2>
    <p>You are extending User's post (1324)</p>
    <div class="errors">
    @include ('errors.list')
    </div>

    {!! Form::open(['url' => 'extensions']) !!}
    @include ('extensions._form', ['submitButtonText' => 'Post Extension'])
    {!! Form::close()   !!}

@stop

@section('centerFooter')
    <div id = "centerFooter">
        <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Save as draft</button></a>
        <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Add Sources</button></a>
    </div>
@stop

@include('posts.rightSide')


