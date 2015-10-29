@extends('app')
@section('siteTitle')
    Discover
@stop
@section('handle')
    {{Auth::user()->handle}}
@stop
@section('centerMenu')
    @if (count($errors) > 0)
        @include('errors.list')
    @endif
@stop
@section('centerText')
    <section>
        @foreach ($posts as $post)
            <article>
                <h2>
                    <a href="{{ action('PostController@show', [$post->id])}}"> {{ $post->title }}</a>
                </h2>
                <div class = "body">{{ $post->elevation }}</div>
            </article>
        @endforeach

    </section>
@stop
@section('centerFooter')
    <h2>test</h2>
@stop

