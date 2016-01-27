@extends('app')
@section('siteTitle')
    Question
@stop
@section('centerText')
    <div>
    <h2><a href={{ url('/questions/'. $question->id)}}>{{$question->question}}</a></h2>
        <p>Top Elevated Extensions</p>
    <table style="display: inline-block;">
        <tr>
            <td><a href={{ url('/questions/'. $question->id)}}>Most Recent</a></td>
            <td><a href={{ url('/indev')}}>Search</a></td>
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

    {!! $extensions->render() !!}

@stop
@section('centerFooter')
    @if($elevation === 'Elevated')
        <a href="{{ url('/questions/'.$question->id) }}"><button type = "button" class = "navButton">{{ $elevation }}</button></a>
    @else
        <a href="{{ url('/questions/elevate/'.$question->id) }}"><button type = "button" class = "navButton">{{ $elevation }}</button></a>
    @endif
    @if($user->type > 1)
        <a href="{{ url('/questions/'.$question->id.'/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
    @else
        <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Report</button></a>
    @endif
    <a href="{{ url('/extensions/question/'. $question->id) }}"><button type = "button" class = "navButton">Extend</button></a>
@stop



