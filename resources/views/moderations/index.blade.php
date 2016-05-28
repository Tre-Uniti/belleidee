@extends('app')
@section('siteTitle')
    Moderations
@stop

@section('centerText')
    <h2>Recent Moderations</h2>
    <div class = "indexNav">
         <a href={{ url('/indev')}}><button type = "button" class = "indexButton">Sort by Oldest</button></a>
           <a href={{ url('/search')}}><button type = "button" class = "indexButton">Search</button></a>
          <a href={{ url('/drafts/create')}}><button type = "button" class = "indexButton">?</button></a>
    </div>
    <div class = "indexLeft">
        <h4>Submitter</h4>
    </div>
    <div class = "indexRight">
        <h4>Date</h4>
    </div>
    @foreach ($moderations as $moderation)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('ModerationController@show', [$moderation->id])}}"><button type = "button" class = "interactButtonLeft">{{ $moderation->user->handle }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('ModerationController@show', [$moderation->id])}}"><button type = "button" class = "interactButton">{{ $moderation->created_at->format('M-d-Y')}}</button></a>
            </div>
        </div>
    @endforeach


@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $moderations])
@stop


