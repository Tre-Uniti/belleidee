@extends('app')
@section('siteTitle')
    Show Intolerance
@stop
@section('centerMenu')
    <h2>Intolerance</h2>
    @if(isset($moderation->post_id))
        <p><a href = {{ action('PostController@show', $moderation->post_id)}}>Source Post</a>
        </p>
    @elseif(isset($moderation->extension_id))
        <p><a href = {{ action('ExtensionController@show', $intolerance->extension_id)}}>Source Extension</a></p>
    @elseif(isset($moderation->question_id))
        <p><a href = {{ action('QuestionController@show', $intolerance->queston_id)}}>Source Question</a></p>
    @endif
@stop
@section('centerText')
    <div id = "centerTextContent">
            <p>
                {{ $moderation->mod_ruling }}
            </p>
        </div>
@stop

@section('centerFooter')
    <div id = "centerFooter">
        @if($moderation->user_id == Auth::id())
            <a href="{{ url('/intolerances/'.$intolerance->id.'/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
        @elseif($user->type > 0)
            <a href="{{ url('/moderations/create') }}"><button type = "button" class = "navButton">Mod</button></a>
        @endif
        @if($user->type > 1)
                {!! Form::open(['method' => 'DELETE', 'route' => ['intolerances.destroy', $intolerance->id]]) !!}
                {!! Form::submit('Delete', ['class' => 'navButton', 'id' => 'delete']) !!}
                {!! Form::close() !!}
        @endif

    </div>
@stop


