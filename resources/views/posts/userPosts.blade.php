@extends('app')
@section('siteTitle')
    Your Posts
@stop

@section('centerText')
    <h2>Posts by <a href={{ url('/users/'. $user->id)}}>{{ $user->handle }}</a></h2>
    <div class = "indexNav">
        <a href="{{ url('/posts/user/elevated/'. $user->id)}}" class = "indexLink">Top <i class="fa fa-heart-o fa-lg" aria-hidden="true"></i></a>
        <a href="{{ url('/users/'.$user->id)}}" class = "indexLink">Profile</a>
        <a href="{{ url('posts/user/extended/'. $user->id)}}" class = "indexLink">Most <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i></a>
    </div>
    <p>Filter by: Recent</p>
    <hr class = "contentSeparator">
    @include('posts._postCards')
@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $posts])
@stop



