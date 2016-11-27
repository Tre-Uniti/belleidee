@extends('app')
@section('siteTitle')
    Search Users
@stop

@section('centerText')
    <h2>Search Results</h2>
        <div class = "indexNav">
            <a href={{ url('/users/')}}><button type = "button" class = "indexButton">Recent User</button></a>
            <a href="{{ url('/results?identifier=' . $identifier) }}" class = "indexLink">Expand Search</a>
            <a href={{ url('/search')}}><button type = "button" class = "indexButton">Global Search</button></a>
        </div>
    <div class = "contentHeaderSeparator">
        <h3>User Results ( {{ $userCount}}@if($userCount == 10)+  @endif ) </h3>
    </div>
    @include ('users._userCards')

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $users->appends(['title' => $identifier])])
@stop



