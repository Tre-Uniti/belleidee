@extends('app')
@section('siteTitle')
    Upload Photo
@stop

@section('centerText')
    <h2>Change Profile Photo</h2>

    {!! Form::open(['url' => 'storePhoto', 'files' => true]) !!}
<div class = "formInput">
    {!! Form::file('image', null, ['class' => 'navButton']) !!}
    {!! Form::label('Max Upload size: 2MB') !!}
</div>
    <div class = "formInput">

    </div>
<div class = "formInput">
    {!! Form::submit('Upload Photo', ['class' => 'navButton']) !!}
    <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
</div>
    {!! Form::close() !!}
@stop

