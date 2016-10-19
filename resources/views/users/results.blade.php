@extends('app')
@section('siteTitle')
    Search Users
@stop

@section('centerText')
    <h2>Search Results</h2>
        <div class = "indexNav">
            <a href={{ url('/users/')}}><button type = "button" class = "indexButton">Recent User</button></a>
            <a href={{ url('/users/search')}}><button type = "button" class = "indexButton">User Search</button></a>
            <a href={{ url('/search')}}><button type = "button" class = "indexButton">Global Search</button></a>
        </div>

    @include ('users._userCards')

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $users->appends(['title' => $handle])])
@stop



