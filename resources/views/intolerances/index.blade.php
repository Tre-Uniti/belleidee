@extends('app')
@section('siteTitle')
    Intolerances
@stop

@section('centerText')
    <div>
    <h2>Recent Intolerances</h2>
    <table style="display: inline-block;">
        <tr>
            <td><a href={{ url('/indev')}}></a>Sort by Oldest</td>
            <td><a href={{ url('/indev')}}>Search</a></td>
            <td><a href={{ url('/drafts/create')}}>Create Draft</a></td>
        </tr>
    </table>
    </div>
    <div style = "width: 50%; float: left;">
        <h4>Submitter</h4>
    </div>
    <div style = "width: 50%; float: right;">
        <h4>Date</h4>
    </div>
    @foreach ($intolerances as $intolerance)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('IntoleranceController@show', [$intolerance->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $intolerance->user->handle }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('IntoleranceController@show', [$intolerance->id])}}"><button type = "button" class = "interactButton">{{ $intolerance->created_at->format('M-d-Y')}}</button></a>
            </div>
        </div>
    @endforeach


@stop
@section('centerFooter')
    {!! $intolerances->render() !!}
@stop



