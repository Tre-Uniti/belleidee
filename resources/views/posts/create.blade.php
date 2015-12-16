@extends('app')
@section('siteTitle')
    Create Post
@stop

@include('posts.leftSide')

@section('centerText')
    @include ('errors.list')

    {!! Form::open(['url' => 'posts']) !!}
    @include ('posts._form', ['submitButtonText' => 'Post Belief'])
@stop



@include('posts.rightSide')


