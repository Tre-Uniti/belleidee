

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
                {!! Form::label('country', 'Country') !!}
            </td>
            <td>
                {!! Form::text('country', $beaconRequest->country, ['class' => 'createTitleText']) !!}
            </td>
        </tr>
        <tr>
            <td>
                {!! Form::label('location', 'City or Region') !!}
            </td>
            <td>
                {!! Form::text('location', $beaconRequest->location, ['class' => 'createTitleText']) !!}
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
                {!! Form::label('website', 'Website') !!}
            </td>
            <td>
                {!! Form::text('website', $beaconRequest->website, ['class' => 'createTitleText']) !!}
            </td>
        </tr>
        <tr>
            <td>
                {!! Form::label('admin', 'Admin') !!}
            </td>
            <td>
                {!! Form::select('admin', $admins, ['class' => 'createTitleText']) !!}
            </td>
        </tr>
        <tr>
            <td>
                {!! Form::label('status', 'Status') !!}
            </td>
            <td>
                {!! Form::select('status', $status, ['class' => 'createTitleText']) !!}
            </td>
        </tr>

    </table>
    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
        {!! Form::close()   !!}
    @stop

</div>