@extends('app')
@section('siteTitle')
    Support Requests
@stop

@section('centerText')
    <div>
    <h2>Recent Support Requests</h2>
    <table align = "center">
        <tr>
            <td><a href={{ url('/supports/create')}}>New Support Request</a></td>
        </tr>
    </table>
    </div>
    <div style = "width: 50%; float: left;">
        <h4>ID - Type - Status</h4>
    </div>
    <div style = "width: 50%; float: right;">
        <h4>Created</h4>
    </div>
    @foreach ($supports as $support)
        <div class = "listResource">
            <div class = "listResourceLeft" style = "padding-left: 0; text-align: center; width: 50%;">
                <a href="{{ action('SupportController@show', [$support->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $support->id }} - {{ $support->type }} - {{ $support->status }} </button></a>
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
