@extends('app')
@section('siteTitle')
    Show Legacy
@stop


@section('centerText')
    <h2>{{ $legacy->belief->name }}</h2>
    <div class = "indexNav">
        <a href="{{ url('/beliefs/'. $legacy->belief->name) }}"><button type = "button" class = "indexButton">Belief</button></a>
        <a href="{{ url('/users/'. $legacy->user->id) }}"><button type = "button" class = "indexButton">{{ $legacy->user->handle }} </button></a>
        <a href="{{ url('/legacyPosts/'. $legacy->belief->name) }}"><button type = "button" class = "indexButton">Legacy Posts</button></a>

    </div>
@stop

@section('centerFooter')
    @if($user->id == $legacy->user->id)
        <a href ="{{ url('legacyPosts/create') }}"><button type = "button" class = "navButton">Create Post</button></a>
    @endif
    @if($user->type > 1)
        <a href="{{ url('/legacies/') }}"><button type = "button" class = "navButton">Legacies</button></a>
        <a href="{{ url('/legacies/'.$legacy->id .'/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
    @endif
@stop