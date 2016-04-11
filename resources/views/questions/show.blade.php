@extends('app')
@section('siteTitle')
    Show Question
@stop

@section('centerMenu')

@stop

@section('centerText')
    <h2>{{ $question->question }}</h2>
        <table align = "center">
            <tr>
                <td><a href={{ url('/questions/sortByElevation/'. $question->id)}}>Top Elevated</a></td>
                <td> <a href = {{ url('/users/'. $question->user_id) }}>{{ $question->user->handle }}</a></td>
                <td><a href={{ url('/questions/sortByExtension/'. $question->id)}}>Most Extended</a></td>
            </tr>
        </table>

    <div style = "width: 50%; float: left;">
        <h4>Answers</h4>
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
                <a href="{{ action('UserController@show', [$extension->user_id])}}"><button type = "button" class = "interactButton">{{ $extension->user->handle}}</button></a>
            </div>
        </div>
    @endforeach
    {!! $extensions->render() !!}

@stop

@section('centerFooter')
    <div id = "centerFooter">
        @if($elevation === 'Elevated')
            <a href="{{ url('/questions/'.$question->id) }}"><button type = "button" class = "navButton">{{ $elevation }}</button></a>
        @else
            <a href="{{ url('/questions/elevate/'.$question->id) }}"><button type = "button" class = "navButton">{{ $elevation }}</button></a>
        @endif
        @if($user->type > 1)
                <a href="{{ url('/questions/'.$question->id.'/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
        @endif
        <a href="{{ url('/extensions/question/'. $question->id) }}"><button type = "button" class = "navButton">Your Answer</button></a>
    </div>
@stop


