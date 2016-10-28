@extends('app')
@section('siteTitle')
    List Invites
@stop

@section('centerMenu')
@include('errors.list')
@stop
@section('centerText')
    <h2>Your Invites:</h2>
    @if ($invites->isEmpty())
        <p>No Invites Yet!</p>
    @else
        @foreach ($invites as $invite)
            <div class = "listResourceLeft">
                <a href="{{ url('/invites')}}"><button type = "button" class = "interactButton">{{ $invite->email }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ url('/invites')}}"><button type = "button" class = "interactButton">{{ $invite->created_at->format('M-d-Y') }}</button></a>
            </div>

        @endforeach
    @endif
@stop

@section('centerFooter')
    <a href="{{ url('/invites/create')}}" class = "navLink">New Invite</a>
    @stop

