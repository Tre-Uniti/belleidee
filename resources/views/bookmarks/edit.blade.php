@extends('app')
@section('siteTitle')
    Create
@stop



@section('centerText')
    <div class = "errors">
        @include ('errors.list')
    </div>

    {!! Form::model($post, ['route' => ['posts.update', $post->id], 'method' => 'patch']) !!}
    @include ('posts._form', ['submitButtonText' => 'Update Post'])

@stop

@section('centerFooter')
@stop

@include('bookmarks.rightSide')