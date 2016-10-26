@extends('app')
@section('siteTitle')
    Elevation of Extension
@stop

@section('centerText')
    <h2>Extensions of  <a href={{ url('/legacyPosts/'. $legacyPost->id)}}>{{ $legacyPost->title }}</a></h2>
    <div class = "indexNav">
        <a href="{{ url('/legacyPosts/'. $legacyPost->id)}}" class = "indexLink">Show Legacy</a>
        <a href="{{ url('/legacyPosts/'. $legacyPost->id)}}" class = "indexLink">Total: {{ $legacyPost->extension }}</a>
        <a href="{{ url('/legacyPosts/list/elevation/'.$legacyPost->id)}}" class = "indexLink">Elevations <i class="fa fa-heart-o fa-lg" aria-hidden="true"></i></a>
    </div>
    <p>Filter: Recent <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i></p>
    <hr class = "contentSeparator"/>
    @include('extensions._extensionCards')

@stop

@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $extensions])
@stop



