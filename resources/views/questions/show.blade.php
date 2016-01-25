@extends('app')
@section('siteTitle')
    Show Question
@stop

@section('centerMenu')
    <h2>{{ $question->question }}</h2>
@stop

@section('centerText')
    <div id = "centerTextContent">
        <table align = "center">
            <tr>
                <td> <a href = {{ url('/indev') }}>{{ $question->created_at->format('M-d-Y') }}</a></td>
            </tr>
        </table>

        @foreach ($extensions as $extension)
            <div class = "listResource">
                <div class = "listResourceLeft">
                    <a href="{{ action('ExtensionController@show', [$extension->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $extension->title }}</button></a>
                </div>
                <div class = "listResourceRight">
                    <a href="{{ action('ExtensionController@show', [$extension->id])}}"><button type = "button" class = "interactButton">{{ $extension->user->handle}}</button></a>
                </div>
            </div>
        @endforeach
    </div>
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
            @else
            <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Report</button></a>
        @endif
        <a href="{{ url('/extensions/question/'. $question->id) }}"><button type = "button" class = "navButton">Extend</button></a>
    </div>
@stop


