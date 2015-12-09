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
            {!! Form::select('belief_beacon', $beacons) !!}
            {!! Form::select('index2', $types) !!}
        </td>
    </tr>
</table>

<!-- Body Form Input -->
    <div id = "centerTextContent">
    {!! Form::textarea('body', null, ['id' => 'createBodyText', 'placeholder' => 'Express your belief here:', 'rows' => '19%']) !!}
    </div>

    {!! Form::submit($submitButtonText, ['class' => 'navButton']) !!}
</div>