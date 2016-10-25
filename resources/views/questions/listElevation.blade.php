@extends('app')
@section('siteTitle')
    Show Elevation
@stop

@section('centerText')
    <h2><a href = "{{ url('/questions/'. $question->id) }}">{{ $question->question }}</a></h2>
    <div class = "indexNav">
        <a href = "{{ url('/users/'. $question->user_id) }}" class = "indexLink">Asked by: {{ $question->user->handle }}</a>
        <a href="{{ url('/questions/sortByExtension/'. $question->id)}}" class = "indexLink">Answers <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i></a>
    </div>
    <p>Filter: <i class="fa fa-heart-o fa-lg" aria-hidden="true"></i></p>
    <hr class = "contentSeparator"/>
    @include('elevations._elevationCards')

@stop

@section('centerFooter')
    {!! $elevations->render() !!}
@stop


