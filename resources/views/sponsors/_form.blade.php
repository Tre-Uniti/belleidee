<div class = "formDataContainer">
    <div class = "formLabel">
        <b>{!! Form::label('name', 'Sponsor Name') !!}</b>
    </div>
    <div class = "formInput">
        {!! Form::text('name', null, ['class' => 'createTitleText', 'autofocus']) !!}
    </div>
    <div class = "formLabel">
        {!! Form::label('address', 'Address:') !!}
        </div>
    <div class = "formInput">
        {!! Form::text('address', null, ['class' => 'createTitleText']) !!}
    </div>
    <div class = "formLabel">
        {!! Form::label('city', 'City:') !!}
    </div>
    <div class = "formInput">
        {!! Form::text('city', null, ['class' => 'createTitleText']) !!}
    </div>
    <div class = "formLabel">
        {!! Form::label('country', 'Country:') !!}
    </div>
    <div class = "formInput">
        {!! Form::text('country', null, ['class' => 'createTitleText']) !!}
    </div>
    <div class = "formLabel">
        {!! Form::label('website', 'Website:') !!}
    </div>
    <div class = "formInput">
        {!! Form::text('website', null, ['class' => 'createTitleText']) !!}
    </div>
    <div class = "formLabel">
        {!! Form::label('phone', 'Phone #:') !!}
    </div>
    <div class = "formInput">
        {!! Form::text('phone', null, ['class' => 'createTitleText']) !!}
    </div>
    <div class = "formLabel">
        {!! Form::label('email', 'Email:') !!}
    </div>
    <div class = "formInput">
        {!! Form::email('email', null, ['class' => 'createTitleText']) !!}
    </div>
    <div class = "formLabel">
        {!! Form::label('view_budget', 'View Budget:') !!}
    </div>
    <div class = "formInput">
        {!! Form::text('view_budget', null, ['class' => 'createTitleText']) !!}
    </div>
    <div class = "formLabel">
        {!! Form::label('click_budget', 'Click Budget:') !!}
    </div>
    <div class = "formInput">
        {!! Form::text('click_budget', null, ['class' => 'createTitleText']) !!}
    </div>
    <div class = "formLabel">
        {!! Form::label('user_id', 'Manager:') !!}
    </div>
    <div class = "formInput">
        {!! Form::text('user_id', null, ['class' => 'createTitleText']) !!}
    </div>
    <div class = "formData">
        <div class = "formLabel">
            {!! Form::label('lat', 'Latitude:') !!}
        </div>
        <div class = "formInput">
            {!! Form::text('lat', null, ['class' => 'createTitleText']) !!}
        </div>
    </div>
    <div class = "formData">
        <div class = "formLabel">
            {!! Form::label('long', 'Longitude:') !!}
        </div>
        <div class = "formInput">
            {!! Form::text('long', null, ['class' => 'createTitleText']) !!}
        </div>
    </div>
    <div class = "formLabel">
        {!! Form::label('adult', 'Adult 21+') !!}
    </div>
    <div class = "formInput">
        {!! Form::checkbox('adult') !!}
    </div>
    <div class = "formLabel">
        {!! Form::label('Max Upload size: 2MB') !!}
    </div>
    <div class = "formInput">
        {!! Form::file('image', null, ['class' => 'navButton']) !!}
    </div>


</div>
    @section('centerFooter')
    {!! Form::submit($submitButtonText, ['class' => 'navButton']) !!}
    <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
    {!! Form::close()   !!}
    @stop

