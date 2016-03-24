@extends('app')
@section('siteTitle')
    Sponsor Requests
@stop

@section('centerText')
    <div>
    <h2>Recent Sponsor Requests</h2>
    <table align = "center">
        <tr>
            <td><a href={{ url('/sponsorRequests/create')}}>New Sponsor Request</a></td>
        </tr>
    </table>
    </div>
    <div style = "width: 50%; float: left;">
        <h4>Name</h4>
    </div>
    <div style = "width: 50%; float: right;">
        <h4>Created</h4>
    </div>
    @foreach ($sponsorRequests as $request)
        <div class = "listResource">
            <div class = "listResourceLeft" style = "padding-left: 0; text-align: center; width: 50%;">
                <a href="{{ action('SponsorRequestController@show', [$request->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $request->name }} </button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('SponsorRequestController@show', [$request->id])}}"><button type = "button" class = "interactButton">{{ $request->created_at->format('M-d-Y')}}</button></a>
            </div>
        </div>
    @endforeach
@stop
@section('centerFooter')
    {!! $sponsorRequests->render() !!}
@stop
