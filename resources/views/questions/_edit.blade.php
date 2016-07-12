@section('pageHeader')
    <script src = "/js/caffeine.js"></script>
    <script src = "/js/submit.js"></script>
@stop
<div id = "createOptions">

    <div class = "formInput">
        {!! Form::label('title', 'Question of the Week:') !!}
    </div>
    <div class = "formInput">
        {!! Form::textarea('question', null, ['id' => 'createBodyText', 'placeholder' => 'What is the next community question?:', 'rows' => '2%', 'maxlength' => '255']) !!}
    </div>
    <div class = "formInput">
        {!! Form::label('handle', 'User Handle') !!}
    </div>
    <div class = "formInput">
        {!! Form::text('handle', $question->user->handle, ['class' => 'createFormText']) !!}
    </div>

    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton', 'id' => 'submit']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
        {!! Form::close()   !!}
    @stop

</div>