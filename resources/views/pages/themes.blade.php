@extends('app')
@section('siteTitle')
    Settings
@stop
@section('centerText')
    <h2>Themes:</h2>
    <p>You may select which theme inspires you while using Idee</p>

    <div class = "formDataContainer">
        {!! Form::model($user, ['route' => ['theme', $user->id], 'method' => 'patch']) !!}
        <div class = "formInput">
            {!! Form::label('theme', 'Select Theme') !!}
        </div>
        <div class = "formInput">
            {!! Form::select('theme', $themes, array('frequency' => $user->theme)) !!}
        </div>
    </div>
    <p><b>Starry Night:</b> Includes background image that may increase load times</p>
@stop
@section('centerFooter')
    {!! Form::submit('Update Theme', ['class' => 'navButton']) !!}
    <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
    {!! Form::close()   !!}
@stop