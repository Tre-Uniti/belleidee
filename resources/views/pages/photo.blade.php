@extends('app')
@section('siteTitle')
    Upload Photo
@stop

@section('centerText')
    <h2>Change Profile Photo</h2>
    <div class = "formDataContainer">
        {!! Form::open(['url' => 'storePhoto', 'files' => true]) !!}
    <div class = "formData">
        <div class = "formLabel">
            {!! Form::label('image', 'Auto-Resized to 450x350') !!}
        </div>
        <div class = "formShowData">
            {!! Form::file('image', null, ['class' => 'navButton']) !!}
        </div>
    </div>

<div class = "formInput">


</div>
    <div class = "formInput">
        Please follow the image guideline <a href = "{{ url('/images') }}" target = "blank">here</a>
    </div>


<div class = "formInput">
    {!! Form::submit('Upload Photo', ['class' => 'navButton']) !!}
    <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
</div>
    {!! Form::close() !!}
@stop

