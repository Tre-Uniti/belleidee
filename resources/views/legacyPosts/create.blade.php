@extends('app')
@section('siteTitle')
    Create Legacy Post
@stop

@section('centerText')
    @include ('errors.list')

    {!! Form::open(['url' => 'legacyPosts', 'files' => true]) !!}
    @include ('legacyPosts._form', ['submitButtonText' => 'Post Legacy'])
@stop


