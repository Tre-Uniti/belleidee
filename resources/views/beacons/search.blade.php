@extends('app')
@section('siteTitle')
    Search Beacons
@stop

@section('centerText')
    <div>
        <h2>Search Beacons</h2>

                <div class = "formDataContainer">
                    {!! Form::open(['url' => 'beacons/results', 'method' => 'GET']) !!}
                    <div class = "formInput">
                        {!! Form::text('identifier', null, ['placeholder' => 'Search text']) !!}
                    </div>


                </div>
        {!! Form::submit('Search', ['class' => 'navButton']) !!}
        {!! Form:: close() !!}
    </div>

@stop
@section('centerFooter')
    <a href="{{ url('/beacons/') }}"><button type = "button" class = "navButton">All Beacons</button></a>
    <a href="{{ url('/beaconRequests/create') }}"><button type = "button" class = "navButton">Request New Beacon</button></a>
    <a href="{{ url('/search') }}"><button type = "button" class = "navButton">Global Search</button></a>
@stop


