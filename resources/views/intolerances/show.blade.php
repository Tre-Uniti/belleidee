@extends('app')
@section('siteTitle')
    Show Intolerance
@stop
@section('centerMenu')
    <h2>Intolerance</h2>
    @if(isset($intolerance->post_id))
        <p><a href = {{ action('PostController@show', $intolerance->post_id)}}>Source Post</a>
        </p>
    @elseif(isset($intolerance->extension_id))
        <p>Source: {{$intolerance->extension_id}}</p>
    @elseif(isset($intolerance->question_id))
        <p>Source: {{$intolerance->question_id}}</p>
    @endif
@stop


@section('centerText')
    <div id = "centerTextContent">
            <p>
                {{ $intolerance->user_ruling }}
            </p>
        </div>

@stop

@section('centerFooter')
    <div id = "centerFooter">
        @if($intolerance->user_id == Auth::id())
            <a href="{{ url('/intolerances/'.$intolerance->id.'/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
        @endif
            <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Back</button></a>
    </div>
@stop

@include('drafts.rightSide')

