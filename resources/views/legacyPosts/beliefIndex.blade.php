@extends('app')
@section('siteTitle')
    Legacy for {{ $belief->name }}
@stop

@section('centerText')
    <h2>Legacy Posts for <a href = "{{ url('/beliefs/'. $belief->name) }}">{{ $belief->name }}</a></h2>
    <a href = " {{ url('/legacyPosts') }}"><button type = "button" class = "indexButton">All Legacy</button></a>
    <a href = " {{ url('/beliefs/' . $belief->name) }}"><button type = "button" class = "indexButton">About {{ $belief->name }}</button></a>

    <p>Filter by: {{ $beacon->belief }}</p>

    <hr class = "contentSeparator"/>
    @include('legacyPosts._legacyPostCards')
@stop

@section('centerFooter')
    @if($user->type >= 2)
        <a href = {{ url('/legacyPosts/create') }}><button type = "button" class = "navButton">Create</button></a>
    @endif
@stop



