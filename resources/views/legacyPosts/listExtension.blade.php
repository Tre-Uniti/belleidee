@extends('app')
@section('siteTitle')
    Elevation of Extension
@stop

@section('centerText')
    <h2>Extensions of  <a href={{ url('/legacyPosts/'. $legacyPost->id)}}>{{ $legacyPost->title }}</a></h2>
    <div class = "indexNav">
        <a href={{ url('/legacyPosts/list/elevation/'.$legacyPost->id)}}><button type = "button" class = "indexButton">Elevations</button></a>
        <a href={{ url('/legacyPosts/'. $legacyPost->id)}}><button type = "button" class = "indexButton">Total: {{ $legacyPost->elevation }}</button></a>
        <a href={{ url('/legacyPosts/'. $legacyPost->id)}}><button type = "button" class = "indexButton">Back</button></a>
    </div>

    <hr class = "contentSeparator"/>
    @include('extensions._extensionCards')

@stop

@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $extensions])
@stop



