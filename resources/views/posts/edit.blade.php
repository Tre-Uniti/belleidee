

@extends('app')
@section('siteTitle')
    Create
@stop

@include('posts.leftSide')

@section('centerText')
    <h1>Edit: {!! $post->title !!}</h1>
    <div class = "errors">
        @include ('errors.list')
    </div>

    {!! Form::model($post, ['route' => ['posts.update', $post->id], 'method' => 'patch']) !!}
    @include ('posts._form', ['submitButtonText' => 'Update Post'])
    {!! Form::close()   !!}

@stop

@section('centerFooter')
@stop

@include('posts.rightSide')