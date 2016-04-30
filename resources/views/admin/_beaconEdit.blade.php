<h2>Edit Beacon Request</h2>
<div class = "formDataContainer">
    <div class = "formData">
        <div class = "formLabel">
          {!! Form::label('name', 'Name') !!}
        </div>
        <div class = "formInput">
            {!! Form::text('name', $beaconRequest->name, ['class' => 'createTitleText', 'autofocus']) !!}
        </div>
    </div>
    <div class = "formData">
        <div class = "formLabel">
         {!! Form::label('belief', 'Belief') !!}
        </div>
     <div class = "formInput">
            {!! Form::select('belief', $beliefs, array('belief' => $beaconRequest->belief)) !!}
     </div>
    </div>
        <div class = "formData">
            <div class = "formLabel">
                {!! Form::label('address', 'Address') !!}
            </div>
            <div class = "formInput">
                {!! Form::text('address', $beaconRequest->address, ['class' => 'createTitleText']) !!}
            </div>
        </div>
        <div class = "formData">
            <div class = "formLabel">
                {!! Form::label('country', 'Country') !!}
            </div>
            <div class = "formInput">
                {!! Form::text('country', $beaconRequest->country, ['class' => 'createTitleText']) !!}
            </div>
        </div>
        <div class = "formData">
            <div class = "formLabel">
                {!! Form::label('city', 'City') !!}
            </div>
            <div class = "formInput">
                {!! Form::text('city', $beaconRequest->location, ['class' => 'createTitleText']) !!}
            </div>
        </div>
        <div class = "formData">
            <div class = "formLabel">
                {!! Form::label('website', 'Website') !!}
            </div>
            <div class = "formInput">
                {!! Form::text('website', $beaconRequest->website, ['class' => 'createTitleText']) !!}
            </div>
        </div>
        <div class = "formData">
            <div class = "formLabel">
                {!! Form::label('phone', 'Phone #') !!}
            </div>
            <div class = "formInput">
                {!! Form::text('phone', $beaconRequest->phone, ['class' => 'createTitleText']) !!}
            </div>
        </div>
        <div class = "formData">
            <div class = "formLabel">
                {!! Form::label('email', 'Email') !!}
            </div>
            <div class = "formInput">
                {!! Form::email('email', $beaconRequest->email, ['class' => 'createTitleText']) !!}
            </div>
        </div>
        <div class = "formData">
            <div class = "formLabel">
                {!! Form::label('admin', 'Admin') !!}
            </div>
            <div class = "formInput">
                {!! Form::select('admin', $admins, ['class' => 'createTitleText']) !!}
            </div>
        </div>
        <div class = "formData">
            <div class = "formLabel">
                {!! Form::label('status', 'Status') !!}
            </div>
            <div class = "formInput">
                {!! Form::select('status', $status, array('status' => $beaconRequest->status)) !!}
            </div>
        </div>

    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
        {!! Form::close()   !!}
    @stop

</div>