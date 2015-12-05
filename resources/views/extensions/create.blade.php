@extends('app')
@section('siteTitle')
    Create Extension
@stop

@include('extensions.leftSide')

@section('centerText')
    @include ('errors.list')

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


