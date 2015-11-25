@extends('app')
@section('siteTitle')
    Create
@stop

@include('posts.leftSide')

@section('centerText')
    <h2>Create Post</h2>
    <div class="errors">
    @include ('errors.list')
    </div>
    {!! Form::open(['url' => 'posts']) !!}
    @include ('posts._form', ['submitButtonText' => 'Post Belief'])
    {!! Form::close()   !!}

@stop

@section('centerFooter')
    <div id = "centerFooter">
        <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Save as draft</button></a>
        <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Add Sources</button></a>
    </div>
@stop

@include('posts.rightSide')


