@extends('app')
@section('siteTitle')
    Create Post
@stop

@section('centerText')
    @include ('errors.list')

    {!! Form::open(['url' => 'posts']) !!}
    @include ('posts._form', ['submitButtonText' => 'Post'])
@stop


