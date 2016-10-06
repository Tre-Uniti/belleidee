@extends('app')
@section('pageHeader')

@section('siteTitle')
    Create Post
@stop

@section('centerText')
    @include ('errors.list')

    {!! Form::open(['url' => 'posts','files' => true]) !!}
    @include ('posts._form', ['submitButtonText' => 'Post' ])
@stop


