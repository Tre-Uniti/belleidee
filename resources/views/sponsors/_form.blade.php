<div id = "createOptions">

    <table align = "center" style = "margin-bottom: 7px;">
        <tr>
            <th colspan= "2">Sponsor</th>
        </tr>
        <tr>
            <td>
                {!! Form::label('name', 'Name') !!}
            </td>
            <td colspan="2">{!! Form::text('name', null, ['class' => 'createTitleText', 'autofocus']) !!}</td>
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
                {!! Form::label('view_budget', 'View Budget') !!}
            </td>
            <td>
                {!! Form::text('view_budget', null, ['class' => 'createTitleText']) !!}
            </td>
        </tr>
        <tr>
            <td>
                {!! Form::label('click_budget', 'Click Budget') !!}
            </td>
            <td>
                {!! Form::text('click_budget', null, ['class' => 'createTitleText']) !!}
            </td>
        </tr>
        <tr>
            <td>
                {!! Form::label('user_id', 'Manager') !!}
            </td>
            <td>
                {!! Form::text('user_id', null, ['class' => 'createTitleText']) !!}
            </td>
        </tr>

        <tr>
            <td>
                {!! Form::label('adult', 'Adult 21+') !!}
            </td>
            <td>
                {!! Form::checkbox('adult') !!}
            </td>
        </tr>
        <tr>
            <td>
                {!! Form::label('Max Upload size: 2MB') !!}
            </td>
            <td>
                {!! Form::file('image', null, ['class' => 'navButton']) !!}
            </td>
        </tr>
    </table>
    @section('centerFooter')
    {!! Form::submit($submitButtonText, ['class' => 'navButton']) !!}
    <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
    {!! Form::close()   !!}
    @stop

</div>
