@extends('app')
@section('siteTitle')
    Create Extension
@stop

@include('extensions.leftSide')

@section('centerText')
    @include ('errors.list')

    {!! Form::open(['url' => 'extensions']) !!}
    @include ('extensions._form', ['submitButtonText' => 'Post Extension'])


@stop

@section('centerFooter')
    <div id = "centerFooter">
        <a href="{{ url('/posts') }}"><button type = "button" class = "navButton">Save as draft</button></a>
    </div>
@stop

@include('posts.rightSide')


