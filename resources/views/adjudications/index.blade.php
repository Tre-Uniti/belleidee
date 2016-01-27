@extends('app')
@section('siteTitle')
    Adjudications
@stop

@section('centerText')
    <div>
    <h2>Recent Adjudications</h2>
    <table style="display: inline-block;">
        <tr>
            <td><a href={{ url('/indev')}}></a>Sort by Oldest</td>
            <td><a href={{ url('/indev')}}>Search</a></td>
            <td><a href={{ url('/indev')}}>In Dev</a></td>
        </tr>
    </table>
    </div>
    <div style = "width: 50%; float: left;">
        <h4>Submitter</h4>
    </div>
    <div style = "width: 50%; float: right;">
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
    {!! $adjudications->render() !!}
@stop


