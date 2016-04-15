<div id = "createOptions">

<table class = "formData">
    <tr>
        <th colspan= "2">{!! Form::label('name', 'Beacon Name') !!}</th>
    </tr>
    <tr>
        <td colspan="2">{!! Form::text('name', null, ['class' => 'createTitleText', 'autofocus']) !!}</td>
    </tr>
    <tr>
        <td>
            {!! Form::label('belief', 'Belief') !!}
        </td>
        <td>
            {!! Form::select('belief', $beliefs) !!}
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
    <tr>
        <td>
            {!! Form::label('country', 'Country') !!}
        </td>
        <td>
            {!! Form::text('country', null, ['class' => 'createTitleText']) !!}
        </td>
    </tr>
    <tr>
        <td>
            {!! Form::label('location', 'City or Region') !!}
        </td>
        <td>
            {!! Form::text('location', null, ['class' => 'createTitleText']) !!}
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
            {!! Form::label('website', 'Website') !!}
        </td>
        <td>
            {!! Form::text('website', null, ['class' => 'createTitleText']) !!}
        </td>
    </tr>
</table>
    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
        {!! Form::close()   !!}
    @stop

</div>