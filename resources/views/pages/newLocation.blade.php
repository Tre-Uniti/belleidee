@extends('app')
@section('pageHeader')
    <script src = '/js/index.js'></script>
@stop
@section('siteTitle')
    New Location
@stop

@section('centerText')
    <div>
        <h2>Select your Location</h2>
        {!! Form::open(['url' => '/addLocation', 'method' =>  'GET']) !!}
        <div class = "formDataContainer">
            <p><a href = "{{ url('/beaconRequests/agreement') }}" target = "_blank">Beacons</a> and your interaction with them set location automatically</p>
            <div class = "formInput">
                {!!  Form::label('country', 'Country (Required):') !!}
            </div>
            <div class = "formInput">
                {!! Form::select('country', $countries) !!}
            </div>
            <div class = "formInput">
                {!!  Form::label('city', 'City (Optional):') !!}
            </div>
            <div class = "formInput">
                {!! Form::text('city', null, ['class' => 'createTitleText', 'placeholder' => 'City Name']) !!}
            </div>
        </div>
        {!! Form::submit('Search', ['class' => 'navButton']) !!}
        {!! Form:: close() !!}
    </div>
@stop