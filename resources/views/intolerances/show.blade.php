@extends('app')
@section('pageHeader')
    <script src = "/js/toggleSource.js"></script>
@stop
@section('siteTitle')
    Show Intolerance
@stop
@section('centerText')
    <h2><a href = {{ url('intolerances') }}>Intolerance</a></h2>
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

