@extends('app')
@section('siteTitle')
    Search Questions
@stop

@section('centerText')
        <h2>Search Results</h2>
        <div class = "indexNav">
            <a href={{ url('/questions/')}}><button type = "button" class = "indexButton">Recent Questions</button></a>
            <a href={{ url('/questions/search')}}><button type = "button" class = "indexButton">Question Search</button></a>
            <a href={{ url('/search')}}><button type = "button" class = "indexButton">Global Search</button></a>
        </div>
<hr class = "contentSeparator"/>
    @include('questions._questionCards')

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $questions->appends(['question' => $question])])
@stop



