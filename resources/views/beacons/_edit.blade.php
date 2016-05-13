<h2>Edit Beacon</h2>
<div class = "formDataContainer">
    <div class = "formData">
        <div class = "formLabel">
            {!! Form::label('name', 'Name') !!}
        </div>
        <div class = "formInput">
            {!! Form::text('name', null, ['class' => 'infoTitleText', 'autofocus']) !!}
        </div>
    </div>
    <div class = "formData">
        <div class = "formLabel">
            {!! Form::label('belief', 'Belief:') !!}
        </div>
        <div class = "formInput">
            {!! Form::select('belief', $beliefs) !!}
        </div>
    </div>
    <div class = "formData">
        <div class = "formLabel">
            {!! Form::label('country', 'Country:') !!}
        </div>
        <div class = "formInput">
            {!! Form::select('country', $countries, $beacon->country, ['class' => 'selectMenu'] ) !!}
        </div>
    </div>
    <div class = "formData">
        <div class = "formLabel">
            {!! Form::label('address', 'Address:') !!}
        </div>
        <div class = "formInput">
            {!! Form::text('address', null, ['class' => 'infoTitleText']) !!}
        </div>
    </div>
    <div class = "formData">
        <div class = "formLabel">
            {!! Form::label('city', 'City:') !!}
        </div>
        <div class = "formInput">
            {!! Form::text('city', null, ['class' => 'infoTitleText']) !!}
        </div>
    </div>
    <div class = "formData">
        <div class = "formLabel">
            {!! Form::label('zip', 'Zip code') !!}
        </div>
        <div class = "formInput">
            {!! Form::text('zip', null, ['class' => 'infoTitleText']) !!}
        </div>
    </div>
    <div class = "formData">
        <div class = "formLabel">
            {!! Form::label('phone', 'Phone #:') !!}
        </div>
        <div class = "formInput">
            {!! Form::text('phone', null, ['class' => 'infoTitleText', 'placeholder' => '+x (xxx) xxx-xxxx'] ) !!}
        </div>
    </div>
    <div class = "formData">
        <div class = "formLabel">
            {!! Form::label('email', 'Email:') !!}
        </div>
        <div class = "formInput">
            {!! Form::email('email', null, ['class' => 'infoTitleText']) !!}
        </div>
    </div>
    <div class = "formData">
        <div class = "formLabel">
            {!! Form::label('website', 'Website:') !!}
        </div>
        <div class = "formInput">
            {!! Form::text('website', null, ['class' => 'infoTitleText']) !!}
        </div>
    </div>
    <div class = "formData">
        <div class = "formLabel">
            {!! Form::label('beacon_tag', 'Beacon Tag:') !!}
        </div>
        <div class = "formInput">
            {!! Form::text('beacon_tag', null, ['class' => 'infoTitleText', 'placeholder' => 'Country-City-Shortname']) !!}
        </div>
    </div>
    <div class = "formData">
        <div class = "formLabel">
            {!! Form::label('guide', 'Beacon Guide:') !!}
        </div>
        <div class = "formInput">
            {!! Form::text('guide', null, ['class' => 'infoTitleText']) !!}
        </div>
    </div>
    <div class = "formData">
        <div class = "formLabel">
            {!! Form::label('manager', 'Manager:') !!}
        </div>
        <div class = "formInput">
            {!! Form::text('manager', null, ['class' => 'infoTitleText']) !!}
        </div>
    </div>
    <div class = "formData">
        <div class = "formLabel">
            {!! Form::label('lat', 'Latitude:') !!}
        </div>
        <div class = "formInput">
            {!! Form::text('lat', null, ['class' => 'infoTitleText']) !!}
        </div>
    </div>
    <div class = "formData">
        <div class = "formLabel">
            {!! Form::label('long', 'Longitude:') !!}
        </div>
        <div class = "formInput">
            {!! Form::text('long', null, ['class' => 'infoTitleText']) !!}
        </div>
    </div>
    <div class = "formData">
        <div class = "formLabel">
            {!! Form::label('Max Upload size: 2MB') !!}
        </div>
        <div class = "formInput">
            {!! Form::file('image', null, ['class' => 'navButton']) !!}
        </div>
    </div>
    {!! Form::hidden('id', $beacon->id) !!}

    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
        {!! Form::close()   !!}
    @stop

</div>