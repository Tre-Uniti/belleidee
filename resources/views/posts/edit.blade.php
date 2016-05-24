@extends('app')
@section('siteTitle')
    Edit Post
@stop


@section('centerText')
    <div class = "errors">
        @include ('errors.list')
    </div>

    {!! Form::model($post, ['route' => ['posts.update', $post->id], 'method' => 'patch', 'files' => true ]) !!}
    @include ('posts._edit', ['submitButtonText' => 'Update Post'])

@stop

