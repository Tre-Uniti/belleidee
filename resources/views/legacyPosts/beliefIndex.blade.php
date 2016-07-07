@extends('app')
@section('siteTitle')
    Legacy for {{ $belief->name }}
@stop

@section('centerText')
    <h2>Legacy Posts for {{ $belief->name }}</h2>
    <p>Legacy posts are created by Admins to help users discover the inspirational texts of each belief.</p>
    <div class = "indexLeft">
        <h4>Title</h4>
    </div>
    <div class = "indexRight">
        <h4>Created</h4>
    </div>
    @foreach($legacyPosts as $legacyPost)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href = {{ url('/legacyPosts/'. $legacyPost->id) }}><button type = "button" class = "interactButton">{{ $legacyPost->title }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href = {{ url('/legacyPosts/'. $legacyPost->id) }}><button type = "button" class = "interactButton">{{ $legacyPost->created_at->format('M-d-Y') }}</button></a>
            </div>
        </div>
    @endforeach
@stop

@section('centerFooter')
    <a href = " {{ url('/beliefs/' . $belief->name) }}"><button type = "button" class = "navButton">About Belief</button></a>
    @if($user->type >= 2)
        <a href = {{ url('/legacyPosts/create') }}><button type = "button" class = "navButton">Create</button></a>
    @endif
@stop



