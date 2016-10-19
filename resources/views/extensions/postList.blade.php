@extends('app')
@section('siteTitle')
    Extensions
@stop

@section('centerText')
    <h2>Extensions of <a href = {{ action('PostController@show', [$sources['post_id']])}}> {{ $sources['post_title'] }}</a></h2>
    <div class = "indexNav">
        <a href={{ url('/posts/'. $post->id)}}><button type = "button" class = "indexButton">Back</button></a>
        <a href={{ url('/posts/'. $post->id)}}><button type = "button" class = "indexButton">Total: {{ $post->extension }}</button></a>
        <a href={{ url('/posts/listElevation/'.$post->id)}}><button type = "button" class = "indexButton">Elevations</button></a>
    </div>

    <hr class = "contentSeparator"/>
    @include('extensions._extensionCards')

@stop

@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $extensions])
@stop
