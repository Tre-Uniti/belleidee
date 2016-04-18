@extends('app')
@section('siteTitle')
    Question Most Extended
@stop
@section('centerText')
    <h2><a href={{ url('/questions/'. $question->id)}}>{{$question->question}}</a></h2>
    <div class = "indexNav">
        <a href={{ url('/questions/sortByElevation/'. $question->id)}}><button type = "button" class = "indexButton">Top Elevated</button></a>
        <a href = {{ url('/users/'. $question->user_id) }}><button type = "button" class = "indexButton">{{ $question->user->handle }}</button></a>
        <a href={{ url('/questions/'. $question->id)}}><button type = "button" class = "indexButton">Most Recent</button></a>
    </div>
    <p>(Most Extended)</p>
    <div class = "indexLeft">
        <h4>Question</h4>
    </div>
    <div class = "indexRight">
        <h4>Handle</h4>
    </div>
        @foreach ($extensions as $extension)

            <div class = "listResource">
            <div class = "listResourceLeft">
            <a href="{{ action('ExtensionController@show', [$extension->id])}}"><button type = "button" class = "interactButtonLeft">{{ $extension->title }}</button></a>
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



