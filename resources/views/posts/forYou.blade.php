@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
@stop
@section('siteTitle')
    Posts
@stop

@section('centerText')
    <div>
    <h2>Posts for You</h2>
        <p>From <a href = " {{ url('users/following/'. $user->id) }}">Users </a> you follow</p>
    <div class = "indexNav">
        <a href="{{ url('/posts')}}" class = "indexLink">Recent</a>
        @if($user->last_tag != null)
            <a href="{{ url('/beacons/posts/'. $user->last_tag)}}" class = "indexLink">{{ $user->last_tag }}</a>
        @endif
        <a href="{{ url('posts/elevationTime/Month')}}" class = "indexLink">Top <i class="fa fa-heart" aria-hidden="true"></i></a>
        <a href="{{ url('posts/extensionTime/Month')}}" class = "indexLink">Most <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i></a>
    </div>
    </div>
    <hr class = "contentSeparator">
    @include('posts._postCards')
@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $posts])
@stop



