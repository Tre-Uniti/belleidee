<div id = "createOptions">

    <div class = "formInput">
        {!! Form::label('title', 'Question of the Week:') !!}
    </div>
    <div class = "formInput">
        {!! Form::text('question', null, ['class' => 'createFormText', 'autofocus']) !!}
    </div>
    <div class = "formInput">
        {!! Form::label('user_id', 'User ID') !!}
    </div>
    <div class = "formInput">
        {!! Form::text('user_id', null, ['class' => 'createFormText']) !!}
    </div>

    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
        {!! Form::close()   !!}
    @stop

</div>