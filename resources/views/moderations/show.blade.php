@extends('app')
@section('pageHeader')
    <script src = "/js/toggleSource.js"></script>
@stop
@section('siteTitle')
    Show Moderation
@stop
@section('centerText')
    <h2><a href = {{ url('moderations') }}>Moderation Overview</a></h2>
    <p><button type = "button" class = "interactButton" id = "content">Show Source</button></p>
    <div class = "extensionContent" id = "hiddenContent">
        @if($intolerance->post_id != null)
            @if($type != 'txt')
                <div class = "photoContent">
                    <a href = "{{ url('/posts/'. $sourceModel->id) }}" target = "_blank"><img src= {{ url(env('IMAGE_LINK'). $sourceModel->post_path) }} alt="{{$sourceModel->title}}"></a>
                </div>
            @else
                {!! nl2br(e($content)) !!}
            @endif
            <p>Created by: <a href = "{{ url('/users/'. $sourceUser['id']) }}" target="_blank">{{ $sourceUser['handle'] }}</a></p>
        @elseif($intolerance->extension_id != null)
            @if($type != 'txt')
                <div class = "photoContent">
                    <a href = "{{ url('/extensions/'. $sourceModel->id) }}" target = "_blank"><img src= {{ url(env('IMAGE_LINK'). $sourceModel->extension_path) }} alt="{{$sourceModel->title}}"></a>
                </div>
            @else
                {!! nl2br(e($content)) !!}
            @endif
            <p>Created by: <a href = "{{ url('/users/'. $sourceUser['id']) }}" target="_blank">{{ $sourceUser['handle'] }}</a></p>
        @endif
    </div>
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
                <a href="{{ url('adjudications/moderation/'. $moderation->id) }}"><button type = "button" class = "navButton">Adjudicate</button></a>
                {!! Form::open(['method' => 'DELETE', 'route' => ['moderations.destroy', $moderation->id]]) !!}
                {!! Form::submit('Delete', ['class' => 'redButton', 'id' => 'delete']) !!}
                {!! Form::close() !!}
        @endif
    </div>
@stop


