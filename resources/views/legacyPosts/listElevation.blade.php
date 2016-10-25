@extends('app')
@section('siteTitle')
    Elevation of Extension
@stop

@section('centerText')
    <h2>Elevations of  <a href={{ url('/legacyPosts/'. $legacyPost->id)}}>{{ $legacyPost->title }}</a></h2>
    <div class = "indexNav">
        <a href="{{ url('/legacyPosts/'. $legacyPost->id)}}" class = "indexLink">Total: {{ $legacyPost->elevation }}</a>
        <a href="{{ url('/legacyPosts/list/extension/'.$legacyPost->id)}}" class = "indexLink">Extensions <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i></a>
    </div>
    <p>Filter: Recent <i class="fa fa-heart-o fa-lg" aria-hidden="true"></i></p>
    <hr class = "contentSeparator"/>
    @include('elevations._elevationCards')

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $elevations])
@stop



