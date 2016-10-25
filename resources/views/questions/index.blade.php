@extends('app')
@section('siteTitle')
    Questions
@stop

@section('centerText')
    <h2>Community Questions</h2>
    <div class = "indexNav">
        <a href="{{ url('/questions/sortByElevation')}}" class = "indexLink">Top <i class="fa fa-heart-o fa-lg" aria-hidden="true"></i></a>
        <a href="{{ url('/questions/sortByExtension')}}" class = "indexLink">Most <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i></a>
    </div>
    <p>Filter by: Recent</p>
    <hr class = "contentSeparator"/>
    @include('questions._questionCards')

@stop
@section('centerFooter')
    {!! $questions->render() !!}
@stop


