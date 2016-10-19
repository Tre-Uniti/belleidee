@extends('app')
@section('siteTitle')
    User Posts
@stop

@section('centerText')
    <h2>Posts by <a href={{ url('/users/'. $user->id)}}>{{ $user->handle }}</a></h2>
    <p>Filter by: Top <i class="fa fa-heart" aria-hidden="true"></i></p>
    <div class = "indexNav">
        <a href="{{ url('posts/user/'. $user->id)}}" class = "indexLink">Recent</a>
        <a href="{{ url('/users/'.$user->id)}}" class = "indexLink">Profile</a>
        <a href="{{ url('posts/user/extended/'. $user->id)}}" class = "indexLink">Most <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i></a>
    </div>
    <hr class = "contentSeparator">
    @include('posts._postCards')
@stop

@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $posts])
@stop
