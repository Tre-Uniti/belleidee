@section('pageHeader')
    <script src = "/js/caffeine.js"></script>
    <script src = "/js/creation.js"></script>
    <script src = "/js/submit.js"></script>
@stop

<div id = "createOptions">
    <h2 id = "creationHeader">Select Creation Type:</h2>
    <button id = "imageButton" type = "button" class = "indexButton">Upload an Image</button>
    <button id = "textButton" type = "button" class = "indexButton">Write an Article</button>
    <div id = "indexInfo" class = "indexContent">
<div class = "formInput">
{!! Form::label('title', 'Post Title:') !!}
</div>
    <div class = "formData">
        {!! Form::text('title', null, ['class' => 'createTitleText', 'autofocus']) !!}
    </div>



<!-- Body Form Input -->

    <div class = "indexContent" id = "imageUpload">
        {!! Form::textarea('caption', null, ['id' => 'createBodyText', 'placeholder' => 'Add optional caption:', 'rows' => '2%', 'maxlength' => '255']) !!}
        <a href = "{{ url('/images') }}" target = "blank">View Image Guidelines</a>
        {!! Form::file('image', null, ['class' => 'navButton']) !!}
        </div>
    <div class = "indexContent" id = "addText">
        {!! Form::textarea('body', null, ['id' => 'createBodyText', 'placeholder' => 'Express your idea or belief here:', 'rows' => '18', 'maxlength' => '3500']) !!}
    </div>

    @section('centerFooter')
        <div id = "footerButtons" class = "indexContent">
        {!! Form::submit($submitButtonText, ['class' => 'navButton', 'id' => 'submit']) !!}
        <button type = "button" id = "back" class = "navButton">Back</button>
    {!! Form::close()   !!}
        </div>
    @stop
</div>