@extends('app')
@section('siteTitle')
    User Extensions
@stop

@section('centerText')
    <h2>Extensions by <a href={{ url('/users/'. $user->id)}}>{{ $user->handle }}</a></h2>
    <div class = "indexNav">
        <a href="{{ url('extensions/user/elevated/'. $user->id)}}" class = "indexLink">Top <i class="fa fa-heart-o fa-lg" aria-hidden="true"></i> </a>
        <a href="{{ url('/users/'. $user->id)}}" class = "indexLink">Profile</a>
        <a href="{{ url('extensions/user/'. $user->id)}}" class = "indexLink">Recent</a>
    </div>
    <p>Filter by: Most <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i></p>
    <hr class = "contentSeparator">
    @include('extensions._extensionCards')

@stop

@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $extensions])
@stop
