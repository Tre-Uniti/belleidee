@extends('app')
@section('siteTitle')
    New Location
@stop

@section('centerText')
    <div>
        <h2>Select your Location</h2>
        {!! Form::open(['url' => '/addLocation', 'method' =>  'GET']) !!}
        <div class = "formDataContainer">
            <div class = "formInput">
                {!!  Form::label('country', 'Country:') !!}
            </div>
            <div class = "formInput">
                {!! Form::select('country', $countries) !!}
            </div>
            <div class = "formInput">
                {!!  Form::label('city', 'City:') !!}
            </div>
            <div class = "formInput">
                {!! Form::text('city', null, ['class' => 'createTitleText', 'placeholder' => 'City Name']) !!}
            </div>
        </div>

        {!! Form::submit('Search', ['class' => 'navButton']) !!}
        {!! Form:: close() !!}
    </div>
@stop