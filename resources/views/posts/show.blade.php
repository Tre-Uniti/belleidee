@extends('app')
@section('siteTitle')
    Show Inspiration
@stop
@section('handle')
    {{Auth::user()->handle}}
@stop

@section('centerText')
    <h1>{{ $post->title }}</h1>

    <article>
        {{ $post->elevation }}
        {{ $post->body }}

    </article>
@stop