@extends('app')
@section('siteTitle')
    Upload Photo
@stop

@section('centerText')
    <h2>Change Sponsor Photo</h2>

    {!! Form::open(['url' => 'sponsors/storePhoto/'.$sponsor->id, 'files' => true]) !!}
    <div class = "formInput">
        {!! Form::file('image', null, ['class' => 'navButton']) !!}
    </div>
    <div class = "formInput">
        {!! Form::label('Recommended height: 200px') !!}
    </div>
    <div class = "formInput">
        {!! Form::submit('Upload Photo', ['class' => 'navButton']) !!}
    </div>
    <a href="{{ url('/sponsors/'.$sponsor->id) }}"><button type = "button" class = "navButton">Cancel</button></a>

    {!! Form::close() !!}

@stop

