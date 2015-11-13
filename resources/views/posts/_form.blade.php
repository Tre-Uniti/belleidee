
<div id = "createOptions">
<table align = "center" style = "margin-bottom: 7px;">
    <tr>
        <th colspan="3" style = "border-color: #E8E8E8;">{!! Form::label('title', 'Title:') !!}</th>
    </tr>
        <tr>
        <td colspan="3" style = "border-color: #E8E8E8;">{!! Form::text('title', null, ['class' => 'createTitleText']) !!}</td>
        </tr>
    <tr><td>Today's Date:  {{ $date }}</td></tr>
    <tr>
            <td colspan="3" style = "border-color: #E8E8E8;">
                {!! Form::text('index', null, ['class' => 'createAttributes', 'placeholder' => 'Belief System']) !!}
                {!! Form::text('belief_beacon', null, ['class' => 'createAttributes' , 'placeholder' => 'Beacon Tag']) !!}
                {!! Form::text('index2', null, ['class' => 'createAttributes', 'placeholder' => 'Type of Post']) !!}
            </td>
    </tr>
</table>
</div>

<!-- Body Form Input -->

    {!! Form::textarea('body', null, ['id' => 'createBodyText', 'placeholder' => 'Express your belief here:', 'rows' => '23%']) !!}


    {!! Form::submit($submitButtonText, ['class' => 'navButton']) !!}
