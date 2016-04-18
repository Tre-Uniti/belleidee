<div id = "createOptions">

    <div class = "formInput">
        <b>{!! Form::label('handle', 'Handle:') !!}</b>
    </div>
    <div class = "formInput">
        {!! Form::text('handle', null, ['class' => 'createTitleText', 'autofocus']) !!}
    </div>
    <div class = "formInput">
        <b>{!! Form::label('email', 'Email:') !!}</b>
    </div>
    <div class = "formInput">
        {!! Form::text('email', null, ['class' => 'createTitleText']) !!}
    </div>
    <div class = "formInput">
        <b>{!! Form::label('frequency', 'Select Frequency:') !!}</b>
    </div>
    <div class = "formInput">
        {!! Form::select('frequency', $frequencies, array('frequency' => $user->frequency)) !!}
    </div>
    <div class = "formInput">
        <b>Type: {{ $user->type }}</b>
    </div>
    <div class = "formInput">
        <a href="{{ url('users/descend/'. $user->id) }}"><button type = "button" class = "navButton">Descend</button></a>
        <a href="{{ url('users/ascend/'. $user->id) }}"><button type = "button" class = "navButton">Ascend</button></a>
    </div>

    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
        {!! Form::close()   !!}
    @stop

</div>