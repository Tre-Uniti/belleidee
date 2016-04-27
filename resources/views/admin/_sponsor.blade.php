<div class = "formDataContainer">
    <div class = "formData">
        <div class = "formLabel">
            {!! Form::label('name', 'Name') !!}
        </div>
        <div class = "formInput">
            {!! Form::text('name', $sponsorRequest->name, ['class' => 'createTitleText', 'autofocus']) !!}
        </div>
    </div>
    <div class = "formData">
        <div class = "formLabel">
            {!! Form::label('address', 'Address') !!}
        </div>
        <div class = "formInput">
            {!! Form::text('address', $sponsorRequest->address, ['class' => 'createTitleText']) !!}
        </div>
    </div>
    <div class = "formData">
        <div class = "formLabel">
            {!! Form::label('country', 'Country') !!}
        </div>
        <div class = "formInput">
            {!! Form::text('country', $sponsorRequest->country, ['class' => 'createTitleText']) !!}
        </div>
    </div>
    <div class = "formData">
        <div class = "formLabel">
            {!! Form::label('location', 'City or Region') !!}
        </div>
        <div class = "formInput">
            {!! Form::text('location', $sponsorRequest->location, ['class' => 'createTitleText']) !!}
        </div>
    </div>
    <div class = "formData">
        <div class = "formLabel">
            {!! Form::label('website', 'Website') !!}
        </div>
        <div class = "formInput">
            {!! Form::text('website', $sponsorRequest->website, ['class' => 'createTitleText']) !!}
        </div>
    </div>
    <div class = "formData">
        <div class = "formLabel">
            {!! Form::label('phone', 'Phone #') !!}
        </div>
        <div class = "formInput">
            {!! Form::text('phone', $sponsorRequest->phone, ['class' => 'createTitleText']) !!}
        </div>
    </div>
    <div class = "formData">
        <div class = "formLabel">
            {!! Form::label('email', 'Email') !!}
        </div>
        <div class = "formInput">
            {!! Form::email('email', $sponsorRequest->email, ['class' => 'createTitleText']) !!}
        </div>
    </div>
    <div class = "formData">
        <div class = "formLabel">
            {!! Form::label('view_budget', 'View Budget') !!}
        </div>
        <div class = "formInput">
            {!! Form::text('view_budget', $sponsorRequest->budget, ['class' => 'createTitleText']) !!}
        </div>
    </div>
    <div class = "formData">
        <div class = "formLabel">
            {!! Form::label('click_budget', 'Click Budget') !!}
        </div>
        <div class = "formInput">
            {!! Form::text('click_budget', $sponsorRequest->budget, ['class' => 'createTitleText']) !!}
        </div>
    </div>
    <div class = "formData">
        <div class = "formLabel">
            {!! Form::label('adult', 'Adult 21+') !!}
        </div>
        <div class = "formInput">
            Yes:{!! Form::checkbox('adult') !!}
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
    {!! Form::hidden('sponsorRequestId', $sponsorRequest->id) !!}

    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
        {!! Form::close()   !!}
    @stop

</div>
