@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
@stop
@section('siteTitle')
    Legacy For You
@stop
@section('centerText')
    <h2>Legacies For You</h2>
    <div id = "indexNav">
        <a href="{{ url('/legacyPosts')}}" class = "indexLink">Recent</a>
        <a href="{{ url('/legacyPosts/elevationTime/Month')}}" class = "indexLink">Top <i class="fa fa-heart-o fa-lg" aria-hidden="true"></i></a>
        <a href="{{ url('/legacyPosts/extensionTime/Month')}}" class = "indexLink">Most <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i></a>
    </div>
    <p>Filter by: {{ $beacon->belief }}</p>

    <hr class = "contentSeparator"/>
    @include('legacyPosts._legacyPostCards')
@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $legacyPosts])
@stop



