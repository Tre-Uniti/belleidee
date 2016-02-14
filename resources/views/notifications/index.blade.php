@extends('app')
@section('siteTitle')
    Support Requests
@stop

@section('centerText')
    <div>
    <h2>Recent Notifications</h2>
    <table align = "center">
        <tr>
            <td><a href={{ url('/users/elevatedBy/'. $user->id)}}>Elevation</a></td>
            <td><a href="{{url('/indev')}}">Clear All</a></td>
            <td><a href={{ url('/users/extendedBy/'. $user->id)}}>Extended</a></td>
        </tr>
    </table>
    </div>
    <div style = "width: 50%; float: left;">
        <h4>Title</h4>
    </div>
    <div style = "width: 50%; float: right;">
        <h4>Type by User</h4>
    </div>
    @foreach ($notifications as $notification)
        <div class = "listResource">
            <div class = "listResourceLeft" style = "padding-left: 0; text-align: center; width: 50%;">
                @if($notification->source_type == 'Post')
                <a href="{{ action('NotificationController@post', [$notification->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $notification->title }} </button></a>
                @elseif($notification->source_type == 'Extension')
                    <a href="{{ action('NotificationController@extension', [$notification->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $notification->title }}</button></a>
                @elseif($notification->source_type == 'Question')
                    <a href="{{ action('NotificationController@question', [$notification->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $notification->title }}</button></a>
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
