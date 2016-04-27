<h2>Update User</h2>
<div class = "formDataContainer">
    <div class = "formLabel">
        {!! Form::label('handle', 'Handle:') !!}
    </div>
    <div class = "formInput">
        {!! Form::text('handle', null, ['class' => 'createTitleText', 'autofocus']) !!}
    </div>
    <div class = "formLabel">
        {!! Form::label('email', 'Email:') !!}
    </div>
    <div class = "formInput">
        {!! Form::text('email', null, ['class' => 'createTitleText']) !!}
    </div>
    <div class = "formLabel">
       {!! Form::label('frequency', 'Select Frequency:') !!}
    </div>
    <div class = "formInput">
        {!! Form::select('frequency', $frequencies, array('frequency' => $user->frequency)) !!}
    </div>
    <div class = "formLabel">
        Type: {{ $user->type }}
    </div>
    <div class = "formInput">
        <a href="{{ url('users/descend/'. $user->id) }}"><button type = "button" class = "navButton">Descend</button></a>
        <a href="{{ url('users/ascend/'. $user->id) }}"><button type = "button" class = "navButton">Ascend</button></a>
    </div>
</div>

    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
        {!! Form::close()   !!}
    @stop

