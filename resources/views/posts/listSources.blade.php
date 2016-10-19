@extends('app')
@section('siteTitle')
    Post Sources
@stop

@section('centerText')
    <h2>Posts sourced from {{ $source }}</h2>
    <div class = "indexNav">
        <a href={{ url('/posts/elevation')}}><button type = "button" class = "indexButton">Elevated</button></a>
        <a href={{ url('/posts/search')}}><button type = "button" class = "indexButton">Search</button></a>
        <a href={{ url('/posts/extension')}}><button type = "button" class = "indexButton">Extended</button></a>
    </div>
    <hr class = "contentSeparator">
    @include('posts._postCards')
@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $posts])
@stop


