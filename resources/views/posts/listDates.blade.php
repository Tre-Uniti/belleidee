@extends('app')
@section('siteTitle')
    Posts by Date
@stop

@section('centerText')
    <h2>Created: {{ $date->format('M-d-Y') }}</h2>
    <div class = "indexNav">
        <a href={{ url('/posts/elevation')}}><button type = "button" class = "indexButton">Elevated</button></a>
        <a href={{ url('/posts')}}><button type = "button" class = "indexButton">New Posts</button></a>
        <a href={{ url('/posts/extension')}}><button type = "button" class = "indexButton">Extended</button></a>
    </div>
    <hr class = "contentSeparator">
    @include('posts._postCards')
@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $posts])
@stop


