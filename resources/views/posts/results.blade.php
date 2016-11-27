@extends('app')
@section('siteTitle')
    Search Posts
@stop
@section('centerText')
    <h2>Search Results</h2>
        <div class = "indexNav">
            <a href={{ url('/posts/')}}><button type = "button" class = "indexButton">Recent Posts</button></a>
            <a href="{{ url('/results?identifier=' . $identifier) }}" class = "indexLink">Expand Search</a>
              <a href={{ url('/search')}}><button type = "button" class = "indexButton">Global Search</button></a>
    </div>
    <div class = "contentHeaderSeparator">
        <h3>Post Results ( {{ $postCount}}@if($postCount == 10)+  @endif ) </h3>
    </div>
    @if(!count($posts))
        <p>0 posts with this title</p>
    @else
        @include('posts._postCards')
    @endif

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $posts->appends(['title' => $identifier])])
@stop



