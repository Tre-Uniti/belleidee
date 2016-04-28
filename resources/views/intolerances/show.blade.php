@extends('app')
@section('siteTitle')
    Show Intolerance
@stop
@section('centerMenu')
    <h2><a href = {{ url('intolerances') }}>Intolerance</a></h2>
    @if(isset($intolerance->post_id))
        <p><a href = {{ action('PostController@show', $intolerance->post_id)}}>Source Post</a>
        </p>
    @elseif(isset($intolerance->extension_id))
        <p><a href = {{ action('ExtensionController@show', $intolerance->extension_id)}}>Source Extension</a></p>
    @elseif(isset($intolerance->question_id))
        <p><a href = {{ action('QuestionController@show', $intolerance->queston_id)}}>Source Question</a></p>
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
        @elseif($user->type > 0)
            <a href="{{ url('/moderations/intolerance/'. $intolerance->id) }}"><button type = "button" class = "navButton">Moderate</button></a>
        @endif
        @if($user->type > 1)
                <a href="{{ url('intolerances/userIndex/'. $user->id) }}"><button type = "button" class = "navButton">Others</button></a>
                {!! Form::open(['method' => 'DELETE', 'route' => ['intolerances.destroy', $intolerance->id], 'class' => 'formDeletion']) !!}
                {!! Form::submit('Delete', ['class' => 'navButton', 'id' => 'delete']) !!}
                {!! Form::close() !!}
        @endif

    </div>
@stop

