@extends('app')
@section('siteTitle')
    Question
@stop
@section('centerText')
    <div>
    <h2>Most Extended Questions</h2>
    <table style="display: inline-block;">
        <tr>
            <td><a href={{ url('/questions/sortByElevation')}}>Top Elevated</a></td>
            <td> <a href = {{ url('/indev') }}>Search</a></td>
            <td><a href={{ url('/questions')}}>Most Recent</a></td>
        </tr>
    </table>
    </div>
    <div style = "width: 50%; float: left;">
        <h4>Question</h4>
    </div>
    <div style = "width: 50%; float: right;">
        <h4>Handle</h4>
    </div>
        @foreach ($questions as $question)

            <div class = "listResource">
            <div class = "listResourceLeft">
            <a href="{{ action('QuestionController@show', [$question->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $question->question }}</button></a>
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


