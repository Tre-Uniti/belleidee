@extends('app')
@section('siteTitle')
    Support Requests
@stop

@section('centerText')
    <h2>Recent Notifications</h2>
    <div class = "indexNav">
        <a href={{ url('/users/elevatedBy/'. $user->id)}}><button type = "button" class = "indexButton">Elevation</button></a>
        <a href="{{url('/notifications/clear')}}"><button type = "button" class = "indexButton">Clear All</button></a>
        <a href={{ url('/users/extendedBy/'. $user->id)}}><button type = "button" class = "indexButton">Extended</button></a>
    </div>
    <div class = "indexLeft">
        <h4>Title</h4>
    </div>
    <div class = "indexRight">
        <h4>Type by User</h4>
    </div>
    @foreach ($notifications as $notification)
        <div class = "listResource">
            <div class = "listResourceLeft">
                @if($notification->source_type == 'Post')
                <a href="{{ action('NotificationController@post', [$notification->id])}}"><button type = "button" class = "interactButtonLeft">{{ $notification->title }} </button></a>
                @elseif($notification->source_type == 'Extension')
                    <a href="{{ action('NotificationController@extension', [$notification->id])}}"><button type = "button" class = "interactButtonLeft">{{ $notification->title }}</button></a>
                @elseif($notification->source_type == 'Question')
                    <a href="{{ action('NotificationController@question', [$notification->id])}}"><button type = "button" class = "interactButtonLeft">{{ $notification->title }}</button></a>
                @endif
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('UserController@show', [$notification->user_id])}}"><button type = "button" class = "interactButton">{{ $notification->type}} by {{ $notification->user->handle }}</button></a>
            </div>
        </div>
    @endforeach
@stop
@section('centerFooter')
    {!! $notifications->render() !!}
@stop
