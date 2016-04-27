<div id = "createOptions">
    <h2>New Community Question</h2>
    <div class = "formDataContainer">

    <div class = "formLabel">
        {!! Form::label('title', 'Community Question') !!}
    </div>
    <div class = "formInput">
        {!! Form::text('question', null, ['class' => 'createTitleText', 'autofocus']) !!}
    </div>
    <div class = "formLabel">
        {!! Form::label('user_id', 'User ID') !!}
    </div>
    <div class = "formInput">
        {!! Form::text('user_id', null, ['class' => 'createTitleText']) !!}
    </div>
    </div>

    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
    {!! Form::close()   !!}
    @stop
</div>