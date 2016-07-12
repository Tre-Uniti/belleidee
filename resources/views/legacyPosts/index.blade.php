@extends('app')
@section('pageHeader')
    <script src = "js/index.js"></script>
@stop
@section('siteTitle')
    Legacies
@stop

@section('centerText')
    <div>
    <h2>Legacy Posts</h2>
    <div class = "indexNav">
        <a href={{ url('/legacyPosts/elevation')}}><button type = "button" class = "indexButton">Elevated</button></a>
        <a href={{ url('/legacyPosts/search')}}><button type = "button" class = "indexButton">Search</button></a>
        <a href={{ url('/legacyPosts/extension')}}><button type = "button" class = "indexButton">Extended</button></a>
    </div>
    <button class = "interactButton" id = "hiddenIndex">More</button>
    <div class = "indexContent" id = "hiddenContent">
        <p>Legacy posts are created by Admins to help users discover the inspirational texts of each belief.</p>
        <a href={{ url('/legacyPosts/timeFilter/Today')}}><button type = "button" class = "indexButton">Today</button></a>
        <a href={{ url('/legacyPosts/timeFilter/Month') }}><button type = "button" class = "indexButton">Month</button></a>
        <a href={{ url('/legacyPosts/timeFilter/Year')}}><button type = "button" class = "indexButton">Year</button></a>
        <a href={{ url('/legacyPosts/timeFilter/All')}}><button type = "button" class = "indexButton">All-time</button></a>
    </div>
    </div>

        <div class = "indexLeft">
            <h4>Title</h4>
        </div>
        <div class = "indexRight">
            <h4>Belief</h4>
        </div>

        @foreach($legacyPosts as $legacyPost)
            <div class = "listResource">
                <div class = "listResourceLeft">
                    <a href = {{ url('/legacyPosts/'. $legacyPost->id) }}><button type = "button" class = "interactButton">{{ $legacyPost->title }}</button></a>
                </div>
                <div class = "listResourceRight">
                    <a href = {{ url('/legacyPosts/belief/'. $legacyPost->legacy->belief->name) }}><button type = "button" class = "interactButton">{{ $legacyPost->legacy->belief->name }}</button></a>
                </div>
            </div>
        @endforeach
@stop

@section('centerFooter')
    @if($user->type >= 2)
        <a href = {{ url('/legacyPosts/create') }}><button type = "button" class = "navButton">Create</button></a>
    @endif
@stop



