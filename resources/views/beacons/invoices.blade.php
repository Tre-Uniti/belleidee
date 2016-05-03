@extends('app')
@section('siteTitle')
    Beacon Invoices
@stop

@section('centerText')
    <div class = "indexNav">
        <a href="{{ url('/belief/index/'. $beacon->belief) }}"><button type = "button" class = "indexButton">{{ $beacon->belief }}</button></a>
        <a href="{{ url('/beacons/tags/'.$beacon->beacon_tag) }}"><button type = "button" class = "indexButton">{{ $beacon->beacon_tag }}</button></a>
        <a href="{{ $beacon->website }}" target="_blank"><button type = "button" class = "indexButton">Website</button></a>

    </div>
    @if($user->type > 1 || $user->id == $beacon->manager)
        <div class = "indexNav">
            <a href="{{ url('/moderations') }}"><button type = "button" class = "indexButton">Moderate</button></a>
        </div>
    @endif
    <div class = "indexLeft">
        <h4>Name</h4>
    </div>
    <div class = "indexRight">
        <h4>Tag</h4>
    </div>

    @foreach ($invoices as $invoice)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('BeaconController@downloadInvoice', [$beacon->id])}}"><button type = "button" class = "interactButtonLeft">{{ $invoice->dateString() }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('BeaconController@downloadInvoice', [$beacon->id, $invoice->id])}}"><button type = "button" class = "interactButton">{{ $invoice->dollars() }}</button></a>
            </div>
        </div>
    @endforeach

@stop
@section('centerFooter')

@stop


