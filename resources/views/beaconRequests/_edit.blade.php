<div id = "createOptions">
    <div class = "formDataContainer">
        <div class = "formData">
            <div class = "formLabel">
                {!! Form::label('name', 'Beacon Name') !!}
            </div>
            <div class = "formInput">
                {!! Form::text('name', null, ['class' => 'createTitleText', 'autofocus']) !!}
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
                {!! Form::select('country', $countries, $beaconRequest->country) !!}
            </div>
        </div>
        <div class = "formData">
            <div class = "formLabel">
                {!! Form::label('address', 'Address:') !!}
            </div>
            <div class = "formInput">
                {!! Form::text('address', null, ['class' => 'createTitleText']) !!}
            </div>
        </div>
        <div class = "formData">
            <div class = "formLabel">
                {!! Form::label('city', 'City:') !!}
            </div>
            <div class = "formInput">
                {!! Form::text('city', null, ['class' => 'createTitleText']) !!}
            </div>
        </div>
        <div class = "formData">
            <div class = "formLabel">
                {!! Form::label('phone', 'Phone #:') !!}
            </div>
            <div class = "formInput">
                {!! Form::text('phone', null, ['class' => 'createTitleText']) !!}
            </div>
        </div>
        <div class = "formData">
            <div class = "formLabel">
                {!! Form::label('email', 'Email:') !!}
            </div>
            <div class = "formInput">
                {!! Form::email('email', null, ['class' => 'createTitleText']) !!}
            </div>
        </div>
        <div class = "formData">
            <div class = "formLabel">
                {!! Form::label('website', 'Website:') !!}
            </div>
            <div class = "formInput">
                {!! Form::text('website', null, ['class' => 'createTitleText']) !!}
            </div>
        </div>
    </div>


    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
        {!! Form::close()   !!}
    @stop
</div>