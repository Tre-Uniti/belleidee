@extends('app')
@section('siteTitle')
    Beliefs
@stop

@section('centerText')
    <h2>Belief Directory</h2>
    <div class = "indexNav">
        @if($beacon != null)
            <a href = "{{ url('/beliefs/' . $beacon->belief) }}" class = "indexLink">For You</a>
        @endif
        <a href="{{ url('/beliefs/topTagged')}}" class = "indexLink">Top <i class="fa fa-hashtag" aria-hidden="true"></i></a>
        <a href="{{ url('/beliefs/mostBeacons')}}" class = "indexLink">Most Beacons</a>
    </div>
    <p>Filter by: Recent Interaction</p>
    <hr class = "contentSeparator"/>
    @include('beliefs._beliefCards')
@stop

@section('centerFooter')
    @if($user->type > 2)
        <a href = {{ url('/beliefs/create') }}><button type = "button" class = "navButton">Create Belief</button></a>
        <a href = {{ url('/legacyPosts/create') }}><button type = "button" class = "navButton">Create Legacy Post</button></a>
    @endif
@stop



