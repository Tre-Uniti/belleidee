@extends('app')
@section('siteTitle')
    Upload Photo
@stop

@section('centerText')
    <h2>Change Profile Photo</h2>

    {!! Form::open(['url' => 'storePhoto', 'files' => true]) !!}
<div class = "formInput">
    {!! Form::file('image', null, ['class' => 'navButton']) !!}

</div>
    <div class = "formInput">
        Please review and accept the image guideline <a href = "{{ url('/images') }}" target="_blank">here</a>:
    </div>
        {!! Form::label('Max Upload size: 10MB') !!}

<div class = "formInput">
    {!! Form::submit('Upload Photo', ['class' => 'navButton']) !!}
    <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
</div>
    {!! Form::close() !!}
@stop

