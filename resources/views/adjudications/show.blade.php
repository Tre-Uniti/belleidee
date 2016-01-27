@extends('app')
@section('siteTitle')
    Show Adjudication
@stop
@section('centerMenu')
    <h2><a href = {{ url('adjudications') }}>Adjudication</a></h2>
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

        <p><b>Admin: </b><a href = {{ action('UserController@show', [$adjudication->user_id])}}>{{ $adjudication->user->handle }} </a></p>

        <p>
            {{ $adjudication->admin_ruling }}
        </p>
    </div>
@stop

@section('centerFooter')
    <div id = "centerFooter">
        @if($user->type > 1)
                {!! Form::open(['method' => 'DELETE', 'route' => ['adjudications.destroy', $adjudication->id]]) !!}
                {!! Form::submit('Delete', ['class' => 'navButton', 'id' => 'delete']) !!}
                {!! Form::close() !!}
        @endif
    </div>
@stop


