@extends('app')
@section('siteTitle')
    Extensions of Question
@stop
@section('centerText')
    <div>
        <h2>Recent Extensions</h2>
        <p>Question: <a href={{ url('/questions/'. $question->id)}}>{{$question->question}}</a></p>
        <table style="display: inline-block;">
            <tr>
                <td><a href={{ url('/questions/sortByElevation/'. $question->id)}}>Top Elevated</a></td>
                <td> <a href = {{ url('/users/'. $question->user_id) }}>{{ $question->user->handle }}</a></td>
                <td><a href={{ url('/questions/sortByExtension/'.$question->id)}}>Most Extended</a></td>
            </tr>
        </table>
    </div>
    <div style = "width: 50%; float: left;">
        <h4>Extension</h4>
    </div>
    <div style = "width: 50%; float: right;">
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
@section('centerFooter')

@stop



