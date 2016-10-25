@extends('app')
@section('siteTitle')
    Elevation of Post
@stop

@section('centerText')
    <h2>Elevation of  <a href={{ url('/posts/'. $post->id)}}>{{ $post->title }}</a></h2>
    <div class = "indexNav">
        <a href="{{ url('/posts/'. $post->id)}}" class = "indexLink">Total: {{ $post->elevation }}</a>
        <a href="{{ url('/extensions/post/list/'.$post->id)}}" class = "indexLink">Extensions <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i></a>
    </div>
    <p>Filter: Recent <i class="fa fa-heart-o fa-lg" aria-hidden="true"></i></p>
<hr class = "contentSeparator"/>
    @include('elevations._elevationCards')

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $elevations])
@stop



