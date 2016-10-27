@extends('app')
@section('siteTitle')
    Support Requests
@stop

@section('centerText')
    <h2>Your Notifications</h2>
    <div class = "indexNav">
        <a href="{{ url('/users/elevatedBy/'. $user->id)}}" class = "indexLink">Recent <i class="fa fa-heart-o fa-lg" aria-hidden="true"></i></a>
        <a href="{{url('/notifications/clear')}}" class = "indexLink">Clear All</a>
        <a href="{{ url('/users/extendedBy/'. $user->id)}}" class = "indexLink">Recent <i class="fa fa-comments-o fa-lg" aria-hidden="true"></i></a>
    </div>
    <hr class = "contentSeparator"/>
    @include('notifications._notificationCards')

@stop
@section('centerFooter')
    {!! $notifications->render() !!}
@stop
