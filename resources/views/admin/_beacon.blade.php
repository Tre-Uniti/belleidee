@section('pageHeader')
    <script src = "/js/caffeine.js"></script>
    <script src = "/js/submit.js"></script>
@stop<h2>Convert to Beacon</h2>
<div class = "formDataContainer">
        <div class = "formData">
            <div class = "formLabel">
                {!! Form::label('name', 'Name:') !!}
            </div>
            <div class = "formInput">
                {!! Form::text('name', $beaconRequest->name, ['class' => 'infoTitleText', 'autofocus']) !!}
            </div>
        </div>
        <div class = "formData">
            <div class = "formLabel">
                {!! Form::label('belief', 'Belief:') !!}
            </div>
            <div class = "formInput">
                {!! Form::select('belief', $beliefs, array('belief' => $beaconRequest->belief)) !!}
            </div>
        </div>
    <div class = "formData">
        <div class = "formLabel">
            {!! Form::label('country', 'Country:') !!}
        </div>
        <div class = "formInput">
            {!! Form::select('country', $countries, $beaconRequest->country, ['class' => 'selectMenu']) !!}
        </div>
    </div>
    <div class = "formData">
        <div class = "formLabel">
            {!! Form::label('address', 'Address:') !!}
        </div>
        <div class = "formInput">
            {!! Form::text('address', $beaconRequest->address, ['class' => 'infoTitleText']) !!}
        </div>
    </div>
    <div class = "formData">
        <div class = "formLabel">
            {!! Form::label('city', 'City:') !!}
        </div>
        <div class = "formInput">
            {!! Form::text('city', $beaconRequest->city, ['class' => 'infoTitleText']) !!}
        </div>
    </div>
    <div class = "formData">
        <div class = "formLabel">
            {!! Form::label('zip', 'Zip code:') !!}
        </div>
        <div class = "formInput">
            {!! Form::text('zip', $beaconRequest->zip, ['class' => 'infoTitleText']) !!}
        </div>
    </div>
        <div class = "formData">
            <div class = "formLabel">
                {!! Form::label('beacon_tag', 'Beacon Tag:') !!}
            </div>
            <div class = "formInput">
                {!! Form::text('beacon_tag', $beaconRequest->country . '-', ['class' => 'infoTitleText', 'placeholder' => 'Country-City-Shortname']) !!}
            </div>
        </div>
        <div class = "formData">
            <div class = "formLabel">
                {!! Form::label('website', 'Website:') !!}
            </div>
            <div class = "formInput">
                {!! Form::text('website', $beaconRequest->website, ['class' => 'infoTitleText']) !!}
            </div>
        </div>
        <div class = "formData">
            <div class = "formLabel">
                {!! Form::label('phone', 'Phone #:') !!}
            </div>
            <div class = "formInput">
                {!! Form::text('phone', $beaconRequest->phone, ['class' => 'infoTitleText']) !!}
            </div>
        </div>
        <div class = "formData">
            <div class = "formLabel">
                {!! Form::label('email', 'Email:') !!}
            </div>
            <div class = "formInput">
                {!! Form::email('email', $beaconRequest->email, ['class' => 'infoTitleText']) !!}
            </div>
        </div>
        <div class = "formData">
            <div class = "formLabel">
                {!! Form::label('manager', 'Manager:') !!}
            </div>
            <div class = "formInput">
                {!! Form::text('manager', $beaconRequest->user_id, ['class' => 'infoTitleText']) !!}
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
                {!! Form::label('Max Upload size: 8MB') !!}
            </div>
            <div class = "formInput">
                {!! Form::file('image', null, ['class' => 'navButton']) !!}
            </div>
        </div>
        {!! Form::hidden('beaconRequestId', $beaconRequest->id) !!}
    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton', 'id' => 'submit']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
        {!! Form::close()   !!}
    @stop

</div>