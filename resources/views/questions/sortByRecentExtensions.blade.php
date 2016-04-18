@extends('app')
@section('siteTitle')
    Extensions of Question
@stop
@section('centerText')
        <h2>Recent Extensions</h2>
        <p>Question: <a href={{ url('/questions/'. $question->id)}}>{{$question->question}}</a></p>

    <div class = "indexNav">
        <a href={{ url('/questions/sortByElevation/'. $question->id)}}><button type = "button" class = "indexButton">Most Recent</button></a>
        <a href = {{ url('/users/'. $question->user_id) }}><button type = "button" class = "indexButton">{{ $question->user->handle }}</button></a>
        <a href={{ url('/questions/sortByExtension/'.$question->id)}}><button type = "button" class = "indexButton">Most Extended</button></a>
    </div>
    <div class = "indexLeft">
        <h4>Extension</h4>
    </div>
    <div class = "indexRight">
        <h4>Handle</h4>
    </div>
    @foreach ($extensions as $extension)

        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('ExtensionController@show', [$extension->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $extension->title }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('UserController@show', [$extension->user_id])}}"><button type = "button" class = "interactButton">{{ $extension->user->handle }}</button></a>
            </div>
        </div>

    @endforeach
@stop




