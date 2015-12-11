@extends('app')
@section('siteTitle')
    Create
@stop

@include('posts.leftSide')

@section('centerText')
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