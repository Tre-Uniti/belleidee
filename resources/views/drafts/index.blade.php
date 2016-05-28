@extends('app')
@section('siteTitle')
    Drafts
@stop

@section('centerText')
    <h2>Recent Drafts</h2>
        <div id = "indexNav">
           <a href={{ url('/drafts/create')}}><button type = "button" class = "indexButton">Create Draft</button></a>
        </div>
    <div class = "indexLeft">
        <h4>Title</h4>
    </div>
    <div class = "indexRight">
        <h4>Date</h4>
    </div>
    @foreach ($drafts as $draft)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('DraftController@show', [$draft->id])}}"><button type = "button" class = "interactButton">{{ $draft->title }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('DraftController@show', [$draft->id])}}"><button type = "button" class = "interactButton">{{ $draft->created_at->format('M-d-Y')}}</button></a>
            </div>
        </div>
    @endforeach

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $drafts])
@stop



