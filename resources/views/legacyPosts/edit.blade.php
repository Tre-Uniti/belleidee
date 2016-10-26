@extends('app')
@section('siteTitle')
    Edit Legacy Post
@stop

@section('centerText')
    <h2>Edit Legacy Post</h2>
    <div class = "errors">
        @include ('errors.list')
    </div>

    {!! Form::model($legacyPost, ['route' => ['legacyPosts.update', $legacyPost->id], 'method' => 'patch', 'files' => true]) !!}
    @include ('legacyPosts._edit', ['submitButtonText' => 'Update Legacy Post'])

@stop

