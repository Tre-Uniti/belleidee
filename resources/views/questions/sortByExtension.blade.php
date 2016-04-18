@extends('app')
@section('siteTitle')
    Question
@stop
@section('centerText')
    <div>
    <h2>Most Extended Questions</h2>
        <div class = "indexNav">
            <a href={{ url('/questions/sortByElevation')}}><button type = "button" class = "indexButton">Top Elevated</button></a>
            <a href = {{ url('/questions/search') }}><button type = "button" class = "indexButton">Search</button></a>
            <a href={{ url('/questions')}}><button type = "button" class = "indexButton">Most Recent</button></a>
        </div>
    </div>
    <div class = "indexLeft">
        <h4>Question</h4>
    </div>
    <div class = "indexRight">
        <h4>Handle</h4>
    </div>
        @foreach ($questions as $question)
            <div class = "listResource">
            <div class = "listResourceLeft">
            <a href="{{ action('QuestionController@show', [$question->id])}}"><button type = "button" class = "interactButtonLeft">{{ $question->question }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('UserController@show', [$question->user_id])}}"><button type = "button" class = "interactButton">{{ $question->user->handle }}</button></a>
            </div>
            </div>
        @endforeach

@stop
@section('centerFooter')
    {!! $questions->render() !!}
@stop


