@extends('app')
@section('siteTitle')
    Legacies
@stop

@section('centerText')
    <h2>Legacy Posts</h2>
    <p>Legacy posts are created by Admins to help users discover the inspirational texts of each belief.</p>
        <div class = "indexLeft">
            <h4>Title</h4>
        </div>
        <div class = "indexRight">
            <h4>Belief</h4>
        </div>

        @foreach($legacyPosts as $legacyPost)
            <div class = "listResource">
                <div class = "indexLeft">
                    <a href = {{ url('/legacyPosts/'. $legacyPost->id) }}><button type = "button" class = "interactButton">{{ $legacyPost->title }}</button></a>
                </div>
                <div class = "listResourceRight">
                    <a href = {{ url('/beliefs/'. $legacyPost->legacy->belief->name) }}><button type = "button" class = "interactButton">{{ $legacyPost->legacy->belief->name }}</button></a>
                </div>
            </div>
        @endforeach
@stop

@section('centerFooter')
    @if($user->type >= 2)
        <a href = {{ url('/legacyPosts/create') }}><button type = "button" class = "navButton">Create</button></a>
    @endif
@stop



