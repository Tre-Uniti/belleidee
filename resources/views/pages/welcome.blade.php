@extends('auth')
@section('siteTitle')
    Welcome to Belle-idee
@stop

@section('centerContent')
<p>
    @if(isset($user))
        <a href="{{ secure_url('/about') }}" class = "navLink">About</a>
    @else
        <a href="{{ secure_url('/login') }}" class = "navLink">Login</a>
        <a href="{{ secure_url('/about') }}" class = "navLink">About</a>
        <a href="{{ secure_url('/register') }}" class = "navLink">Join</a>
    @endif
</p>

    <div class = "contentHeaderSeparator">
        <h3>Recent Legacy</h3>
    </div>
    @include('legacyPosts._legacyPostCards')
<div class = "contentCard">
    <h4>We are an online community sharing spiritual ideas, values and experiences.</h4>
    <p><a href = "/about" class = "navLink">Learn More</a></p>
</div>
<a href= "#" class= "back-to-top" >
    Back to Top
    <i class= "fa fa-arrow-circle-up 2x"></i>
</a>
@stop
