@extends('app')
@section('siteTitle')
    Search Extensions
@stop

@section('centerText')
        <h2>Search Results</h2>
        <div class = "indexNav">
            <a href={{ url('/extensions/')}}><button type = "button" class = "indexButton">Recent Extensions</button></a>
            <a href={{ url('/extensions/search')}}><button type = "button" class = "indexButton">Extension Search</button></a>
            <a href={{ url('/search')}}><button type = "button" class = "indexButton">Global Search</button></a>
        </div>
        <hr class = "contentSeparator">
       @include('extensions._extensionCards')
@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $extensions->appends(['title' => $title])])
@stop



