@extends('app')
@section('siteTitle')
    Show Answers
@stop

@section('centerText')
    <h2><a href = "{{ url('/questions/'. $question->id) }}">{{ $question->question }}</a></h2>
    <div class = "indexNav">
        <a href="{{ url('/questions/sortByElevation/'. $question->id)}}" class = "indexLink">Top <i class="fa fa-heart-o fa-lg" aria-hidden="true"></i></a>
        <a href = "{{ url('/users/'. $question->user_id) }}" class = "indexLink">Asked by: {{ $question->user->handle }}</a>
        <a href="{{ url('/questions/sortByExtension/'. $question->id)}}" class = "indexLink">Most <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i></a>
    </div>
    <p>Filter: Recent Answers</p>
    <hr class = "contentSeparator"/>

    @include('questions._answerCards')
    @if($user->type > 2)
        <a href="{{ url('/questions/'.$question->id.'/edit') }}" class = "indexLink">Edit</a>
    @endif
    <p>
        <a href="{{ url('/extensions/question/'. $question->id) }}" class = "indexLink">Your Answer</a>
    </p>
    <div class = "footerSection">
        <div class = "leftSection">
            <div class = "leftIcon">
                @if($question->elevationStatus === 'Elevated')
                    <i class="fa fa-heart fa-lg" aria-hidden="true"></i>
                @else
                    <a href="{{ url('/questions/'.$question->id) }}" class = "iconLink"><i class="fa fa-heart-o fa-lg" aria-hidden="true"></i></a>
                @endif
                <span class="tooltiptext">Heart to give thanks and recommend to others</span>
            </div>
            <div class = "leftCounter">
                <a href={{ url('/questions/list/elevation/'.$question->id)}}>{{ $question->elevation }}</a>
            </div>
        </div>

        <div class = "centerSection">

        </div>

        <div class = "rightSection">
            <div class = "rightIcon">
                <a href="{{ url('/extensions/question/'. $question->id) }}" class = "iconLink"><i class="fa fa-comments-o fa-lg" aria-hidden="true"></i></a>
                <span class="tooltiptext">Extend to add any inspiration you received</span>
            </div>
            <div class = "rightCounter">
                <a href = "{{ url('/questions/showAnswers/'. $question->id) }}">{{ $question->extension }}</a>
            </div>
        </div>
    </div>
@stop

@section('centerFooter')
    {!! $extensions->render() !!}
@stop


