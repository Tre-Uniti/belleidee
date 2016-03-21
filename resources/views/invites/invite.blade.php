@extends('app')
@section('siteTitle')
    List Invites
@stop

@section('centerMenu')
@include('errors.list')
@stop
@section('centerText')
    <h2>Idee Invites:</h2>
    @if ($invites->isEmpty())
        <a href="{{ url('/invites/create')}}"><button type = "button" class = "interactButton">Create New</button></a>
    @else
        @foreach ($invites as $invite)
            <div style = "width: 35%; float: left; text-align: left; padding-left: 12%; overflow: auto;">
                <a href="{{ url('/invites')}}"><button type = "button" class = "interactButton">{{ $invite->email }}</button></a>
            </div>
            <div style = "width: 50%; float: right;">
                <a href="{{ url('/invites')}}"><button type = "button" class = "interactButton">{{ $invite->created_at->format('M-d-Y') }}</button></a>
            </div>

        @endforeach
            <a href="{{ url('/invites/create')}}"><button type = "button" class = "interactButton">New Invite</button></a>
    @endif
@stop

