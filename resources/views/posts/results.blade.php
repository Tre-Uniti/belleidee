@extends('app')
@section('siteTitle')
    Search Posts
@stop
@section('centerText')
    <h2>Search Results</h2>
        <div class = "indexNav">
            <a href={{ url('/posts/')}}><button type = "button" class = "indexButton">Recent Posts</button></a>
               <a href={{ url('/posts/search')}}><button type = "button" class = "indexButton">Post Search</button></a>
              <a href={{ url('/search')}}><button type = "button" class = "indexButton">Global Search</button></a>
    </div>
    <div class = "contentHeaderSeparator">
        <h3>Post Results</h3>
    </div>
    @if(!count($posts))
        <p>0 posts with this title</p>
    @else
        @include('posts._postCards')
    @endif

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $posts->appends(['title' => $title])])
@stop



