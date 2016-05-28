@extends('app')
@section('siteTitle')
    Intolerances
@stop

@section('centerText')
    <h2>Recent Intolerances</h2>
    <div class = "indexNav">
       <a href={{ url('/indev')}}><button type = "button" class = "indexButton">Sort by Oldest</button></a>
        <a href={{ url('/indev')}}><button type = "button" class = "indexButton">Search</button></a>
        <a href={{ url('/indev')}}><button type = "button" class = "indexButton">Sort by Type</button></a>
    </div>
    <div class = "indexLeft">
        <h4>Submitter</h4>
    </div>
    <div class = "indexRight">
        <h4>Date</h4>
    </div>
    @foreach ($intolerances as $intolerance)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('IntoleranceController@show', [$intolerance->id])}}"><button type = "button" class = "interactButtonLeft">{{ $intolerance->user->handle }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('IntoleranceController@show', [$intolerance->id])}}"><button type = "button" class = "interactButton">{{ $intolerance->created_at->format('M-d-Y')}}</button></a>
            </div>
        </div>
    @endforeach


@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $intolerances])
@stop



