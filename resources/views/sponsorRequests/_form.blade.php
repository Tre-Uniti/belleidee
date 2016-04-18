<div id = "createOptions">

    <div class = "formInput">
        <b>{!! Form::label('name', 'Sponsor Name') !!}</b>
    </div>
    <div class = "formInput">
        {!! Form::text('name', null, ['class' => 'createTitleText', 'autofocus']) !!}
    </div>
    <div class = "formInput">
        {!! Form::label('address', 'Address') !!}
    </div>
    <div class = "formInput">
        {!! Form::text('address', null, ['class' => 'createTitleText']) !!}
    </div>
    <div class = "formInput">
        {!! Form::label('country', 'Country') !!}
    </div>
    <div class = "formInput">
        {!! Form::text('country', null, ['class' => 'createTitleText']) !!}
    </div>
    <div class = "formInput">
        {!! Form::label('location', 'City or Region') !!}
    </div>
    <div class = "formInput">
        {!! Form::text('location', null, ['class' => 'createTitleText']) !!}
    </div>
    <div class = "formInput">
        {!! Form::label('phone', 'Phone #') !!}
    </div>
    <div class = "formInput">
        {!! Form::text('phone', null, ['class' => 'createTitleText']) !!}
    </div>
    <div class = "formInput">
        {!! Form::label('email', 'Email') !!}
    </div>
    <div class = "formInput">
        {!! Form::email('email', null, ['class' => 'createTitleText']) !!}
    </div>
    <div class = "formInput">
        {!! Form::label('website', 'Website') !!}
    </div>
    <div class = "formInput">

        {!! Form::text('website', null, ['class' => 'createTitleText']) !!}
    </div>
    <div class = "formInput">
        {!! Form::label('adult', 'Adult 21+') !!}
        {!! Form::checkbox('adult') !!}
    </div>



</div>

    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
        {!! Form::close()   !!}
    @stop

