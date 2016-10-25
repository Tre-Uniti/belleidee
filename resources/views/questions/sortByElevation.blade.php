@extends('app')
@section('siteTitle')
    Question
@stop
@section('centerText')
    <h2>Community Questions</h2>
    <div class = "indexNav">
        <a href="{{ url('/questions/')}}" class = "indexLink">Recent </a>
        <a href="{{ url('/questions/sortByExtension')}}" class = "indexLink">Most <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i></a>
    </div>
    <p>Filter: Top <i class="fa fa-heart-o fa-lg" aria-hidden="true"></i></p>

    <hr class = "contentSeparator"/>
    @include('questions._questionCards')

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $questions])
@stop



