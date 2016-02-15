<div id = "createOptions">

    <table align = "center" style = "margin-bottom: 7px;">
        <tr>
            <th colspan="3" style = "border: none;">{!! Form::label('handle', 'Handle') !!}</th>
        </tr>
        <tr>
            <td colspan="3" style = "border: none;">{!! Form::text('handle', null, ['class' => 'createTitleText', 'autofocus']) !!}</td>
        </tr>
        <tr>
            <th colspan="3" style = "border: none;">{!! Form::label('email', 'Email') !!}</th>
        </tr>
        <tr>
            <td colspan="3" style = "border: none;">{!! Form::text('email', null, ['class' => 'createTitleText']) !!}</td>
        </tr>
        <tr>
            <td colspan="3" style = "border: none;">Type: {{ $user->type }}</td>
        </tr>
        <tr>
            <td><a href="{{ url('users/descend/'. $user->id) }}"><button type = "button" class = "navButton">Descend</button></a></td>
            <td><a href="{{ url('users/ascend/'. $user->id) }}"><button type = "button" class = "navButton">Ascend</button></a></td>
        </tr>

    </table>

    <!-- Body Form Input -->
    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
        {!! Form::close()   !!}
    @stop

</div>