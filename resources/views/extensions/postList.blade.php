@extends('app')
@section('siteTitle')
    Extensions
@stop

@section('centerText')
    <h2>Extensions of <a href = {{ action('PostController@show', [$sources['post_id']])}}> {{ $sources['post_title'] }}</a></h2>
    <div class = "indexNav">
        <a href="{{ url('/posts/'. $post->id)}}" class = "indexLink">Total: {{ $post->extension }}</a>
        <a href="{{ url('/posts/listElevation/'.$post->id)}}" class = "indexLink">Elevations <i class="fa fa-heart fa-lg" aria-hidden="true"></i></a>
    </div>
    <p>Filter: Recent <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i></p>
    <hr class = "contentSeparator"/>
    @include('extensions._extensionCards')

@stop

@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $extensions])
@stop
