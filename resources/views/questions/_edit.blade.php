<div id = "createOptions">

    <table align = "center" style = "margin-bottom: 7px;">
        <tr>
            <th colspan="3" style = "border: none;">{!! Form::label('title', 'Question of the Week:') !!}</th>
        </tr>
        <tr>
            <td colspan="3" style = "border: none;">{!! Form::text('question', null, ['class' => 'createTitleText', 'autofocus']) !!}</td>
        </tr>
        <tr>
            <th colspan="3" style = "border: none;">{!! Form::label('user_id', 'User ID') !!}</th>
        </tr>
        <tr>
            <td colspan="3" style = "border: none;">{!! Form::text('user_id', null, ['class' => 'createTitleText']) !!}</td>
        </tr>
    </table>

    <!-- Body Form Input -->
    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
        {!! Form::close()   !!}
    @stop

</div>