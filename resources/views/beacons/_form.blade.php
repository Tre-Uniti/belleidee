<div id = "createOptions">

<table align = "center" style = "margin-bottom: 7px;">
    <tr>
        <th colspan= "2">{!! Form::label('name', 'Beacon Name') !!}</th>
    </tr>
    <tr>
        <td colspan="2">{!! Form::text('name', null, ['class' => 'createTitleText', 'autofocus']) !!}</td>
    </tr>
    <tr>
        <td>
            {!! Form::label('name', 'Belief') !!}
        </td>
        <td>
            {!! Form::select('index', $beliefs) !!}
        </td>
    </tr>

    <tr>
        <td>
            {!! Form::label('beacon_tag', 'Beacon Tag') !!}
        </td>
        <td>
            {!! Form::text('beacon_tag', null, ['class' => 'createTitleText', 'placeholder' => 'Country-City-Shortname']) !!}
        </td>
    </tr>
    <tr>
        <td>
            {!! Form::label('website', 'Website') !!}
        </td>
        <td>
            {!! Form::text('website', null, ['class' => 'createTitleText']) !!}
        </td>
    </tr>
    <tr>
        <td>
            {!! Form::label('phone', 'Phone #') !!}
        </td>
        <td>
            {!! Form::text('phone', null, ['class' => 'createTitleText']) !!}
        </td>
    </tr>
    <tr>
        <td>
            {!! Form::label('email', 'Email') !!}
        </td>
        <td>
            {!! Form::email('email', null, ['class' => 'createTitleText']) !!}
        </td>
    </tr>
    <tr>
        <td>
            {!! Form::label('address', 'Address') !!}
        </td>
        <td>
            {!! Form::text('address', null, ['class' => 'createTitleText']) !!}
        </td>
    </tr>
</table>
    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton']) !!}
        <!-- Later Implementation<a href="{{ url('/drafts') }}"><button type = "button" class = "navButton">Save as draft</button></a>-->
        <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
    {!! Form::close()   !!}
    @stop

</div>