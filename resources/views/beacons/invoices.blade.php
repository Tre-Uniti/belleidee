@extends('app')
@section('siteTitle')
    Beacon Invoices
@stop

@section('centerText')
    <h2>Invoices for <a href = "{{ url('beacons/'. $beacon->beacon_tag)}}">{{ $beacon->name }}</a></h2>
    @if($user->type > 1 || $user->id == $beacon->manager)
        <div class = "indexNav">
            <a href="{{ url('/beacons/'. $beacon->beacon_tag )}}"><button type = "button" class = "indexButton">Profile</button></a>
            <a href="{{ url('/beacons/subscription/'. $beacon->id )}}"><button type = "button" class = "indexButton">Subscription</button></a>
            <a href="{{ url('/intolerances/beacon/'. $beacon->id) }}"><button type = "button" class = "indexButton">Intolerance</button></a>
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
                <a href="{{ action('BeaconController@downloadInvoice', [$beacon->id, $invoice->id])}}"><button type = "button" class = "interactButtonLeft">{{ $invoice->dateString() }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('BeaconController@downloadInvoice', [$beacon->id, $invoice->id])}}"><button type = "button" class = "interactButton">{{ $invoice->dollars() }}</button></a>
            </div>
        </div>
    @endforeach

@stop
@section('centerFooter')

@stop



