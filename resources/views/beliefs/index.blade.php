@extends('app')
@section('siteTitle')
    Beliefs
@stop

@section('centerText')
    <h2>Belief Directory</h2>
        <div class = "indexLeft">
            <h4>Belief</h4>
        </div>
        <div class = "indexRight">
            <h4>Legacy Posts</h4>
        </div>

        @foreach($beliefs as $belief)
            <div class = "listResource">
                <div class = "indexLeft">
                    <a href = {{ url('/beliefs/'. $belief->name) }}><button type = "button" class = "interactButton">{{ $belief->name }}</button></a>
                </div>
                <div class = "listResourceRight">
                    <a href = {{ url('/legacyPosts/belief/'. $belief->name) }}><button type = "button" class = "interactButton">{{ $belief->legacy_posts }}</button></a>
                </div>
            </div>
        @endforeach
@stop

@section('centerFooter')
    @if($user->type > 2)
        <a href = {{ url('/beliefs/create') }}><button type = "button" class = "navButton">Create Belief</button></a>
        <a href = {{ url('/legacyPosts/create') }}><button type = "button" class = "navButton">Create Legacy Post</button></a>
    @endif
@stop



