@extends('app')
@section('siteTitle')
    Upload Photo
@stop

@section('centerText')
    <h2>Change Profile Photo</h2>

    {!! Form::open(['url' => 'storePhoto', 'files' => true]) !!}
<table class = "formData">

    <tr>
        <td>{!! Form::file('image', null, ['class' => 'navButton']) !!}</td>
    </tr>
    <tr>
        <td>
            {!! Form::label('Max Upload size: 2MB') !!}
        </td>
    </tr>
    <tr>
        <td>
            {!! Form::submit('Upload Photo', ['class' => 'navButton']) !!}
            <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
        </td>
    </tr>
</table>
    {!! Form::close() !!}
@stop

