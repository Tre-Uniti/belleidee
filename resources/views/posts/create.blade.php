@extends('app')
@section('siteTitle')
    Create Post
@stop

@include('posts.leftSide')

@section('centerText')
    <h2>Create Post</h2>
    @include ('errors.list')

    {!! Form::open(['url' => 'posts']) !!}
    @include ('posts._form', ['submitButtonText' => 'Post Belief'])
    {!! Form::close()   !!}

@stop

@section('centerFooter')
    <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Save as draft</button></a>

@stop

@include('posts.rightSide')


