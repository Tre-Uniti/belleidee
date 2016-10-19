@extends('app')
@section('siteTitle')
    Legacy Posts by Date
@stop

@section('centerText')
    <h2>Legacies Created on {{ $date->format('M-d-Y') }}</h2>
    <div id = "indexNav">
        <a href="{{ url('/legacyPosts/forYou')}}" class = "indexLink">For You</a>
        <a href="{{ url('/legacyPosts/elevationTime/Month')}}" class = "indexLink">Top <i class="fa fa-heart" aria-hidden="true"></i></a>
        <a href="{{ url('/legacyPosts/extensionTime/Month')}}" class = "indexLink">Most <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i></a>
    </div>
    <p>Legacy posts are created by Admins to help Users discover the inspirational texts of each belief.</p>

    <hr class = "contentSeparator"/>
    @include('legacyPosts._legacyPostCards')

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $legacyPosts])
@stop


