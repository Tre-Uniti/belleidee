<div id = "createOptions">

    <table class = "formData">
        <tr>
            <th colspan= "2">Sponsor</th>
        </tr>
        <tr>
            <td>
                {!! Form::label('name', 'Name') !!}
            </td>
            <td colspan="2">{!! Form::text('name', $sponsorRequest->name, ['class' => 'createTitleText', 'autofocus']) !!}</td>
        </tr>
        <tr>
            <td>
                {!! Form::label('address', 'Address') !!}
            </td>
            <td>
                {!! Form::text('address', $sponsorRequest->address, ['class' => 'createTitleText']) !!}
            </td>
        </tr>
        <tr>
            <td>
                {!! Form::label('country', 'Country') !!}
            </td>
            <td>
                {!! Form::text('country', $sponsorRequest->country, ['class' => 'createTitleText']) !!}
            </td>
        </tr>
        <tr>
            <td>
                {!! Form::label('location', 'City or Region') !!}
            </td>
            <td>
                {!! Form::text('location', $sponsorRequest->location, ['class' => 'createTitleText']) !!}
            </td>
        </tr>
        <tr>
            <td>
                {!! Form::label('website', 'Website') !!}
            </td>
            <td>
                {!! Form::text('website', $sponsorRequest->website, ['class' => 'createTitleText']) !!}
            </td>
        </tr>
        <tr>
            <td>
                {!! Form::label('phone', 'Phone #') !!}
            </td>
            <td>
                {!! Form::text('phone', $sponsorRequest->phone, ['class' => 'createTitleText']) !!}
            </td>
        </tr>
        <tr>
            <td>
                {!! Form::label('email', 'Email') !!}
            </td>
            <td>
                {!! Form::email('email', $sponsorRequest->email, ['class' => 'createTitleText']) !!}
            </td>
        </tr>
        <tr>
            <td>
                {!! Form::label('view_budget', 'View Budget') !!}
            </td>
            <td>
                {!! Form::text('view_budget', $sponsorRequest->budget, ['class' => 'createTitleText']) !!}
            </td>
        </tr>
        <tr>
            <td>
                {!! Form::label('click_budget', 'Click Budget') !!}
            </td>
            <td>
                {!! Form::text('click_budget', $sponsorRequest->budget, ['class' => 'createTitleText']) !!}
            </td>
        </tr>

        <tr>
            <td>
                {!! Form::label('adult', 'Adult 21+') !!}
            </td>
            <td>
                Yes:{!! Form::checkbox('adult') !!}
            </td>
        </tr>
        <tr>
            <td>
                {!! Form::label('Max Upload size: 2MB') !!}
            </td>
            <td>
                {!! Form::file('image', null, ['class' => 'navButton']) !!}
            </td>
            {!! Form::hidden('sponsorRequestId', $sponsorRequest->id) !!}
        </tr>
    </table>
    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
        {!! Form::close()   !!}
    @stop

</div>
