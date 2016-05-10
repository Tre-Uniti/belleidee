@extends('app')
@section('siteTitle')
    Support Requests
@stop

@section('centerText')
    <h2>Recent Support Requests</h2>
    <div class = "indexNav">
      <a href={{ url('/supports/create')}}><button type = "button" class = "indexButton">New Support Request</button></a>

    </div>
    <div class = "indexLeft">
        <h4>Type - Status</h4>
    </div>
    <div class = "indexRight">
        <h4>Created</h4>
    </div>
    @foreach ($supports as $support)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('SupportController@show', [$support->id])}}"><button type = "button" class = "interactButtonLeft">{{ $support->type }} - {{ $support->status }} </button></a>
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
