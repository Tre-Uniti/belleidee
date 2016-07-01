@extends('app')
@section('siteTitle')
    Legacies
@stop

@section('centerText')
    <h2>Legacy Posts</h2>
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
                    <a href = {{ url('/users/'. $legacyPost->user_id) }}><button type = "button" class = "interactButton">{{ $legacyPost->legacy->belief->name }}</button></a>
                </div>
            </div>
        @endforeach
@stop

@section('centerFooter')
    @if($user->type > 2)
        <a href = {{ url('/legacies/create') }}><button type = "button" class = "navButton">Create</button></a>
    @endif
@stop



