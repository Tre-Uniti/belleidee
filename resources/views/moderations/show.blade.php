@extends('app')
@section('siteTitle')
    Show Moderation
@stop
@section('centerMenu')
    <h2><a href = {{ url('moderations') }}>Moderation</a></h2>
    @if($intolerance->post_id != '')
        <p><a href = {{ action('PostController@show', [$intolerance->post_id])}}>Source Post</a></p>
    @elseif($intolerance->extension_id != '')
        <p><a href = {{ action('ExtensionController@show', [$intolerance->extension_id])}}>Source Extension</a></p>
    @endif
@stop
@section('centerText')
    <div id = "centerTextContent">
        <p><b>User: </b><a href = {{ action('UserController@show', [$intolerance->user_id])}}>{{ $intolerance->user->handle }} </a></p>
        <p>
            {{ $intolerance->user_ruling }}
        </p>
        <p><b>Moderator: </b><a href = {{ action('UserController@show', [$moderation->user_id])}}>{{ $moderation->user->handle }} </a></p>

        <p>
            {{ $moderation->mod_ruling }}
        </p>
    </div>
@stop

@section('centerFooter')
    <div id = "centerFooter">
        @if($moderation->user_id == Auth::id())
            <a href="{{ url('/moderations/'.$moderation->id.'/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
        @endif
        @if($user->type > 1)
                <a href="{{ url('moderations/userIndex/'. $user->id) }}"><button type = "button" class = "navButton">Others</button></a>
                <a href="{{ url('/adjudications/moderation/'. $moderation->id) }}"><button type = "button" class = "navButton">Adjudicate</button></a>
                {!! Form::open(['method' => 'DELETE', 'route' => ['moderations.destroy', $moderation->id]]) !!}
                {!! Form::submit('Delete', ['class' => 'navButton', 'id' => 'delete']) !!}
                {!! Form::close() !!}
        @endif
    </div>
@stop


