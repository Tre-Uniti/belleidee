@extends('app')
@section('siteTitle')
    Search Extensions
@stop

@section('centerText')
        <h2>Search Results</h2>
        <div class = "indexNav">
            <a href={{ url('/extensions/')}}><button type = "button" class = "indexButton">Recent Extensions</button></a>
            <a href="{{ url('/results?identifier=' . $identifier) }}" class = "indexLink">Expand Search</a>
            <a href={{ url('/search')}}><button type = "button" class = "indexButton">Global Search</button></a>
        </div>
        <div class = "contentHeaderSeparator">
            <h3>Extension Results ( {{ $extensionCount}}@if($extensionCount == 10)+  @endif ) </h3>
        </div>
       @include('extensions._extensionCards')
@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $extensions->appends(['title' => $identifier])])
@stop



