@extends('app')
@section('pageHeader')
    <script src = "js/index.js"></script>
@stop
@section('siteTitle')
    Recent Legacy Posts
@stop

@section('centerText')
    <h2>Recent Legacy Posts</h2>
        <div id = "indexNav">
            <a href="{{ url('/legacyPosts/forYou')}}" class = "indexLink">For You</a>
            <a href="{{ url('/legacyPosts/elevationTime/Month')}}" class = "indexLink">Top <i class="fa fa-heart-o fa-lg" aria-hidden="true"></i></a>
            <a href="{{ url('/legacyPosts/extensionTime/Month')}}" class = "indexLink">Most <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i></a>
        </div>
        <p>Legacy posts are created by Admins to help Users discover the inspirational texts of each belief.</p>
    @if($user->type >= 2)
        <a href = "{{ url('/legacyPosts/create') }}" class = "navLink">Create Legacy Post</a>
    @endif
    <hr class = "contentSeparator"/>
   @include('legacyPosts._legacyPostCards')
@stop

@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $legacyPosts])
@stop



