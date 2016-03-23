<div id = "createOptions">

    <table align = "center" style = "margin-bottom: 7px;">
        <tr>
            <th colspan= "2">{!! Form::label('name', 'Beacon Name') !!}</th>
        </tr>
        <tr>
            <td colspan="2">{!! Form::text('name', $beaconRequest->name, ['class' => 'createTitleText', 'autofocus']) !!}</td>
        </tr>
        <tr>
            <td>
                {!! Form::label('belief', 'Belief') !!}
            </td>
            <td>
                {!! Form::select('belief', $beliefs, array('belief' => $beaconRequest->belief)) !!}
            </td>
        </tr>
        <tr>
            <td>
                {!! Form::label('address', 'Address') !!}
            </td>
            <td>
                {!! Form::text('address', $beaconRequest->address, ['class' => 'createTitleText']) !!}
            </td>
        </tr>
        <tr>
            <td>
                {!! Form::label('beacon_tag', 'Beacon Tag') !!}
            </td>
            <td>
                {!! Form::text('beacon_tag', $beaconRequest->country . '-' . $beaconRequest->location, ['class' => 'createTitleText', 'placeholder' => 'Country-City-Shortname']) !!}
            </td>
        </tr>
        <tr>
            <td>
                {!! Form::label('website', 'Website') !!}
            </td>
            <td>
                {!! Form::text('website', $beaconRequest->website, ['class' => 'createTitleText']) !!}
            </td>
        </tr>
        <tr>
            <td>
                {!! Form::label('phone', 'Phone #') !!}
            </td>
            <td>
                {!! Form::text('phone', $beaconRequest->phone, ['class' => 'createTitleText']) !!}
            </td>
        </tr>
        <tr>
            <td>
                {!! Form::label('email', 'Email') !!}
            </td>
            <td>
                {!! Form::email('email', $beaconRequest->email, ['class' => 'createTitleText']) !!}
            </td>
        </tr>
        <tr>
            <td>
                {!! Form::label('manager', 'Manager') !!}
            </td>
            <td>
                {!! Form::text('manager', $beaconRequest->user_id, ['class' => 'createTitleText']) !!}
            </td>
        </tr>
        <tr>
            <td>
                {!! Form::label('guide', 'Beacon Guide') !!}
            </td>
            <td>
                {!! Form::text('guide', null, ['class' => 'createTitleText']) !!}
            </td>
        </tr>
        <tr>
            <td>
                {!! Form::label('tier', 'Tier') !!}
            </td>
            <td>
                {!! Form::text('tier', null, ['class' => 'createTitleText']) !!}
            </td>
        </tr>
        <tr>
            <td>
                {!! Form::label('Max Upload size: 2MB') !!}
            </td>
            <td>
                {!! Form::file('image', null, ['class' => 'navButton']) !!}
            </td>
            {!! Form::hidden('beaconRequestId', $beaconRequest->id) !!}
        </tr>
    </table>
    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
        {!! Form::close()   !!}
    @stop

</div>