<div id = "createOptions">
    <h2>Support Request</h2>
    <div id = "createOptions">
        <div class = "formData">
            <div class = "formData">
                {!! Form::label('type', 'Type:') !!}
            </div>
            <div class = "formInput">
                {!! Form::select('type', $types) !!}
            </div>
        </div>
        <div class = "formData">
            <div class = "formData">
                {!! Form::label('subject', 'Subject') !!}
            </div>
            <div class = "formInput">
                {!! Form::text('subject', null, ['class' => 'infoTitleText', 'autofocus']) !!}
            </div>
        </div>

        {!! Form::textarea('request', null, ['id' => 'createBodyText', 'placeholder' => 'What can we help with?', 'rows' => '3%', 'maxlength' => '300']) !!}

    </div>
    <!-- Body Form Input -->
    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
        {!! Form::close()   !!}
    @stop
</div>