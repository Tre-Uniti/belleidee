@extends('app')
@section('siteTitle')
    Support Requests
@stop

@section('centerText')
    <div>
    <h2>Recent Support Requests</h2>
    <table style="display: inline-block;">
        <tr>
            <td><a href={{ url('/indev')}}></a>Sort by Oldest</td>
            <td><a href={{ url('/indev')}}>Search</a></td>
            <td><a href={{ url('/drafts/create')}}>Create Draft</a></td>
        </tr>
    </table>
    </div>
    <div style = "width: 50%; float: left;">
        <h4>Title</h4>
    </div>
    <div style = "width: 50%; float: right;">
        <h4>Date</h4>
    </div>
    @foreach ($supports as $support)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('SupportController@show', [$support->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $support->id }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('SupportController@show', [$support->id])}}"><button type = "button" class = "interactButton">{{ $support->created_at->format('M-d-Y')}}</button></a>
            </div>
        </div>
    @endforeach


@stop
@section('centerFooter')
    {!! $supports->render() !!}
@stop



