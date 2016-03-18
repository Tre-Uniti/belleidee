@extends('app')
@section('siteTitle')
    Show Post
@stop
@section('centerMenu')
    <h2>Locked for Intolerance</h2>
@stop

@section('centerText')
    <div id = "centerTextContent">

        <p><b>User: </b></p>
        <p>
            {{ $intolerance->user_ruling }}
        </p>
        <p><b>Moderator: </b></p>
        <p>
            {{ $moderation->mod_ruling }}
        </p>
        <p><b>Admin: </b></p>
        <p>
            {{ $adjudication->admin_ruling }}
        </p>
    </div>

@stop

@section('centerFooter')
    <div id = "centerFooter">
        <a href="{{ url('/posts/unlock/'. $post->id) }}"><button type = "button" class = "navButton">Unlock and View</button></a>
        @if($user->type > 1)
            <a href="{{ url('/admin/removeLock') }}"><button type = "button" class = "navButton">Remove Lock</button></a>
        @endif
    </div>
@stop

