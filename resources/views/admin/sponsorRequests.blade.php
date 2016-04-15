@extends('app')
@section('siteTitle')
    Sponsor Requests
@stop

@section('centerText')
        <h2>Recent Sponsor Requests</h2>
        <div class = "indexNav">
            <a href={{ url('/sponsors/create')}}><button type = "button" class = "indexButton"> New Sponsor</button></a>
            <a href={{ url('/sponsorRequests/create')}}><button type = "button" class = "indexButton">New Sponsor Request</button></a>
        </div>
    <div class = "indexLeft">
        <h4>Name</h4>
    </div>
    <div class = "indexRight">
        <h4>Created</h4>
    </div>
    @foreach ($sponsorRequests as $request)
        <div class = "listResource">
            <div class = "listResourceLeft" style = "padding-left: 0; text-align: center; width: 50%;">
                <a href="{{ action('AdminController@reviewSponsorRequest', [$request->id])}}"><button type = "button" class = "interactButtonLeft">{{ $request->name }} </button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('AdminController@reviewSponsorRequest', [$request->id])}}"><button type = "button" class = "interactButton">{{ $request->created_at->format('M-d-Y')}}</button></a>
            </div>
        </div>
    @endforeach
@stop
@section('centerFooter')
    {!! $sponsorRequests->render() !!}
@stop
