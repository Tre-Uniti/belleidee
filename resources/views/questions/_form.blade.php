@section('pageHeader')
    <script src = "/js/caffeine.js"></script>
    <script src = "/js/submit.js"></script>
@stop
<div id = "createOptions">
    <h2>New Community Question</h2>
    <div class = "formDataContainer">

    <div class = "formData">
        {!! Form::label('title', 'Community Question') !!}
    </div>
    <div class = "formData">
        {!! Form::textarea('question', null, ['id' => 'createBodyText', 'placeholder' => 'What is the next community question?:', 'rows' => '2%', 'maxlength' => '255']) !!}
    </div>
    <div class = "formData">
        {!! Form::label('handle', 'User Handle') !!}
    </div>
    <div class = "formData">
        {!! Form::text('handle', null, ['class' => 'createFormText']) !!}
    </div>
    </div>

    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton', 'id' => 'submit']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
    {!! Form::close()   !!}
    @stop
</div>