@extends('app')
@section('pageHeader')
    <script src = "/js/toggleSource.js"></script>
@stop
@section('siteTitle')
    Show Intolerance
@stop
@section('centerText')
    <h2>Intolerance Report for
        @if($intolerance->post_id != null)
            <a href="{{ action('PostController@show', [$intolerance->post_id])}}" target = "_blank">Post {{ $intolerance->post_id }}</a>
        @elseif($intolerance->extension_id != null)
            <a href="{{ action('ExtensionController@show', [$intolerance->extension_id])}}" target = "_blank">Extension {{ $intolerance->extension_id }}</a>
        @endif
    </h2>
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
                This content is intolerant because it contains: {{ $intolerance->user_ruling }}
            </p>
    </div>
@stop

@section('centerFooter')
    <div id = "centerFooter">
        @if($intolerance->user_id == Auth::id())
            <a href="{{ url('/intolerances/'.$intolerance->id.'/edit') }}" class = "navLink">Edit</a>
        @elseif($user->type > 0)
            <a href="{{ url('/moderations/intolerance/'. $intolerance->id) }}" class = "navLink">Moderate</a>
        @endif
        @if($user->type > 2)
                <a href="{{ url('intolerances/userIndex/'. $user->id) }}"><button type = "button" class = "navButton">Others</button></a>
                {!! Form::open(['method' => 'DELETE', 'route' => ['intolerances.destroy', $intolerance->id], 'class' => 'formDeletion']) !!}
                {!! Form::submit('Delete', ['class' => 'redButton', 'id' => 'delete']) !!}
                {!! Form::close() !!}
        @endif

    </div>
@stop

