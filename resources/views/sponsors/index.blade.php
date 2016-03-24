@extends('app')
@section('siteTitle')
    Sponsors
@stop

@section('centerText')
    <div>
    <h2>Sponsor Directory</h2>
    <table style="display: inline-block;">
        <tr>
            <td><a href={{ url('/sponsors/top')}}>Most Views</a></td>
            <td><a href={{ url('/sponsors/search')}}>Search</a></td>
            <td><a href={{ url('/sponsorRequests')}}>Sponsor Requests</a></td>
        </tr>
    </table>
    </div>
    <div style = "width: 50%; float: left;">
        <h4>Name</h4>
    </div>
    <div style = "width: 50%; float: right;">
        <h4>Views</h4>
    </div>
    @foreach ($sponsors as $sponsor)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('SponsorController@show', [$sponsor->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $sponsor->name }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('SponsorController@show', [$sponsor->id])}}"><button type = "button" class = "interactButton">{{ $sponsor->views}}</button></a>
            </div>
        </div>
    @endforeach

@stop
@section('centerFooter')
    {!! $sponsors->render() !!}
@stop


