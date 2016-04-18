<div id = "createOptions">

    <div class = "formInput">
        <b>{!! Form::label('name', 'Sponsor Name') !!}</b>
    </div>
    <div class = "formInput">
        {!! Form::text('name', null, ['class' => 'createTitleText', 'autofocus']) !!}
    </div>
    <div class = "formInput">
        {!! Form::label('address', 'Address:') !!}
        {!! Form::text('address', null, ['class' => 'createTitleText']) !!}
        {!! Form::label('location', 'City:') !!}
        {!! Form::text('location', null, ['class' => 'createTitleText']) !!}
    </div>
    <div class = "formInput">
        {!! Form::label('country', 'Country:') !!}
    </div>
    <div class = "formInput">
        {!! Form::text('country', null, ['class' => 'createTitleText']) !!}
    </div>
    <div class = "formInput">
        {!! Form::label('website', 'Website:') !!}
    </div>
    <div class = "formInput">
        {!! Form::text('website', null, ['class' => 'createTitleText']) !!}
    </div>
    <div class = "formInput">
        {!! Form::label('phone', 'Phone #:') !!}
    </div>
    <div class = "formInput">
        {!! Form::text('phone', null, ['class' => 'createTitleText']) !!}
    </div>
    <div class = "formInput">
        {!! Form::label('email', 'Email:') !!}
    </div>
    <div class = "formInput">
        {!! Form::email('email', null, ['class' => 'createTitleText']) !!}
    </div>
    <div class = "formInput">
        {!! Form::label('view_budget', 'View Budget:') !!}
    </div>
    <div class = "formInput">
        {!! Form::text('view_budget', null, ['class' => 'createTitleText']) !!}
    </div>
    <div class = "formInput">
        {!! Form::label('click_budget', 'Click Budget:') !!}
    </div>
    <div class = "formInput">
        {!! Form::text('click_budget', null, ['class' => 'createTitleText']) !!}
    </div>
    <div class = "formInput">
        {!! Form::label('user_id', 'Manager:') !!}
    </div>
    <div class = "formInput">
        {!! Form::text('user_id', null, ['class' => 'createTitleText']) !!}
    </div>
    <div class = "formInput">
        {!! Form::label('adult', 'Adult 21+') !!}
    </div>
    <div class = "formInput">
        {!! Form::checkbox('adult') !!}
    </div>
    <div class = "formInput">
        {!! Form::label('Max Upload size: 2MB') !!}

        {!! Form::file('image', null, ['class' => 'navButton']) !!}
    </div>
    @section('centerFooter')
    {!! Form::submit($submitButtonText, ['class' => 'navButton']) !!}
    <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
    {!! Form::close()   !!}
    @stop

</div>
