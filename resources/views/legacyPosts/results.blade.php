@extends('app')
@section('siteTitle')
    Search Legacy Posts
@stop
@section('centerText')
    <h2>Legacy Posts</h2>
        <div class = "indexNav">
            <a href={{ url('/legacyPosts/')}}><button type = "button" class = "indexButton">Recent Legacy</button></a>
            <a href="{{ url('/results?identifier=' . $identifier) }}" class = "indexLink">Expand Search</a>
            <a href={{ url('/search')}}><button type = "button" class = "indexButton">Global Search</button></a>
    </div>

    <div class = "contentHeaderSeparator">
        <h3>Legacy Search Results ( {{ $legacyPostCount}}@if($legacyPostCount == 10)+  @endif ) </h3>
    </div>
    @include('legacyPosts._legacyPostCards')
@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $legacyPosts->appends(['identifier', $identifier ])])
@stop



