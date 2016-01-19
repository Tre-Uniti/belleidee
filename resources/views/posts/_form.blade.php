<div id = "createOptions">

<table align = "center" style = "margin-bottom: 7px;">
    <tr>
        <th colspan="3" style = "border-color: #E8E8E8;">{!! Form::label('title', 'Post Title:') !!}</th>
    </tr>
    <tr>
        <td colspan="3" style = "border-color: #E8E8E8;">{!! Form::text('title', null, ['class' => 'createTitleText', 'autofocus']) !!}</td>
    </tr>
    <tr>
        <td colspan="3" style = "border-color: #E8E8E8;">
            {!! Form::select('index', $beliefs) !!}
            {!! Form::select('beacon_tag', $beacons) !!}
            {!! Form::select('index2', $types) !!}
        </td>
    </tr>
</table>

<!-- Body Form Input -->
    <div id = "centerTextContent">
    {!! Form::textarea('body', null, ['id' => 'createBodyText', 'placeholder' => 'Express your belief here:', 'rows' => '19', 'maxlength' => '3500']) !!}
    </div>
    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton', 'id' => 'submit']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" id = "cancel" class = "navButton">Cancel</button></a>
    {!! Form::close()   !!}
    @stop

</div>