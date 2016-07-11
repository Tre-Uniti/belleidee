@extends('app')
@section('siteTitle')
    Legacy Posts by Date
@stop

@section('centerText')
    <h2>Created: {{ $date->format('M-d-Y') }}</h2>
    <div class = "indexNav">
        <a href={{ url('/legacyPosts')}}><button type = "button" class = "indexButton">New Legacy Posts</button></a>
    </div>
    <div class = "indexLeft">
        <h4>Title</h4>
    </div>
    <div class = "indexRight">
        <h4>Belief</h4>
    </div>

    @foreach ($legacyPosts as $legacyPost)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('LegacyPostController@show', [$legacyPost->id])}}"><button type = "button" class = "interactButton">{{ $legacyPost->title }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('BeliefController@show', [$legacyPost->belief])}}"><button type = "button" class = "interactButton">{{ $legacyPost->belief }}</button></a>
            </div>
        </div>
    @endforeach

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $legacyPosts])
@stop


