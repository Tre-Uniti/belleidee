@extends('app')
@section('siteTitle')
    Create Legacy Post
@stop

@section('centerText')
    <h2>Create Legacy Post</h2>
    @include ('errors.list')

    {!! Form::open(['url' => 'legacyPosts']) !!}
    @include ('legacyPosts._form', ['submitButtonText' => 'Create Legacy Post'])
@stop


