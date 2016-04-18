@extends('app')
@section('siteTitle')
    Questions
@stop

@section('centerText')
    <h2>Community Questions</h2>
    <div class = "indexNav">
        <a href={{ url('/questions/sortByElevation')}}><button type = "button" class = "indexButton">Elevated</button></a>
        <a href={{ url('/questions/search')}}><button type = "button" class = "indexButton">Search</button></a>
        <a href={{ url('/questions/sortByExtension')}}><button type = "button" class = "indexButton">Extended</button></a>
    </div>
    <div class = "indexLeft">
        <h4>Question</h4>
    </div>
    <div class = "indexRight">
        <h4>Asked By</h4>
    </div>
    @foreach ($questions as $question)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('QuestionController@show', [$question->id])}}"><button type = "button" class = "interactButtonLeft">{{ $question->question }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('UserController@show', [$question->user->id])}}"><button type = "button" class = "interactButton">{{ $question->user->handle}}</button></a>
            </div>
        </div>
    @endforeach

@stop
@section('centerFooter')
    {!! $questions->render() !!}
@stop


