@extends('app')
@section('siteTitle')
    Adjudications
@stop
@section('centerText')
    <h2>Recent Adjudications</h2>
    <div class = "indexNav">
        <a href={{ url('/indev')}}><button type = "button" class = "indexButton">Sort by Oldest</button></a>
        <a href={{ url('/indev')}}><button type = "button" class = "indexButton">Search</button></a>
        <a href={{ url('/indev')}}><button type = "button" class = "indexButton">In Dev</button></a>
    </div>
    <div class = "indexLeft">
        <h4>Submitter</h4>
    </div>
    <div class = "indexRight">
        <h4>Date</h4>
    </div>
    @foreach ($adjudications as $adjudication)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('AdjudicationController@show', [$adjudication->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $adjudication->user->handle }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('AdjudicationController@show', [$adjudication->id])}}"><button type = "button" class = "interactButton">{{ $adjudication->created_at->format('M-d-Y')}}</button></a>
            </div>
        </div>
    @endforeach
@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $adjudications])
@stop


