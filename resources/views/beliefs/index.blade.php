@extends('app')
@section('siteTitle')
    Beliefs
@stop

@section('centerText')
    <h2>Belief Directory</h2>
    <div class = "indexNav">
        <a href="{{ url('/beliefs/topPosts')}}" class = "indexLink">Top Posts</a>
        <a href="{{ url('/beliefs/mostBeacons')}}" class = "indexLink">Most Beacons</a>
    </div>
    <p>Filter by: Recent</p>
    <hr class = "contentSeparator"/>
    @include('beliefs._beliefCards')
@stop

@section('centerFooter')
    @if($user->type > 2)
        <a href = {{ url('/beliefs/create') }}><button type = "button" class = "navButton">Create Belief</button></a>
        <a href = {{ url('/legacyPosts/create') }}><button type = "button" class = "navButton">Create Legacy Post</button></a>
    @endif
@stop



