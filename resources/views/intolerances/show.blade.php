@extends('app')
@section('pageHeader')
    <script src = "/js/toggleSource.js"></script>
@stop
@section('siteTitle')
    Show Intolerance
@stop
@section('centerMenu')
    <h2><a href = {{ url('intolerances') }}>Intolerance</a></h2>
    @if($intolerance->post_id != null)
        <p><button type = "button" class = "interactButton" id = "content">Show Source Text</button></p>
        <div class = "extensionContent" id = "hiddenContent">{!! nl2br(e($content)) !!}
            <p>Created by: <a href = "{{ url('/users/'. $sourceUser['id']) }}" target="_blank">{{ $sourceUser['handle'] }}</a></p></div>
    @elseif($intolerance->extension_id != null)
        <p><button type = "button" class = "interactButton" id = "content">Show Source Text</button></p>
        <div class = "extensionContent" id = "hiddenContent">{!! nl2br(e($content)) !!}
            <p>Created by: <a href = "{{ url('/users/'. $sourceUser['id']) }}" target="_blank">{{ $sourceUser['handle'] }}</a></p></div>
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

