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
            {!! Form::label('title', 'Draft Title:') !!}
        </div>
        <div class = "formData">
            {!! Form::text('title', null, ['class' => 'createTitleText', 'autofocus']) !!}
        </div>
        <div class = "formData">
            <select name = 'belief' required >
                <option value="" disabled selected>Belief or Way:</option>
                <option value="Adaptia" @if (old('belief') == 'Adaptia') selected="selected" @endif>Adaptia</option>
                <option value="Atheism" @if (old('belief') == 'Atheism') selected="selected" @endif>Atheism</option>
                <option value="Buddhism" @if (old('belief') == 'Buddhism') selected="selected" @endif>Buddhism</option>
                <option value="Christianity" @if (old('belief') == 'Christianity') selected="selected" @endif>Christianity</option>
                <option value="Druze" @if (old('belief') == 'Druze') selected="selected" @endif>Druze</option>
                <option value="Hinduism" @if (old('belief') == 'Hinduism') selected="selected" @endif>Hinduism</option>
                <option value="Islam" @if (old('belief') == 'Islam') selected="selected" @endif>Islam</option>
                <option value="Indigenous" @if (old('belief') == 'Indigenous') selected="selected" @endif>Indigenous</option>
                <option value="Judaism" @if (old('belief') == 'Judaism') selected="selected" @endif>Judaism</option>
                <option value="Shinto" @if (old('belief') == 'Shinto') selected="selected" @endif>Shinto</option>
                <option value="Sikhism" @if (old('belief') == 'Sikhism') selected="selected" @endif>Sikhism</option>
                <option value="Taoism" @if (old('belief') == 'Taoism') selected="selected" @endif>Taoism</option>
                <option value="Urantia" @if (old('belief') == 'Urantia') selected="selected" @endif>Urantia</option>
                <option value="Zoroastrianism" @if (old('belief') == 'Zoroastrianism') selected="selected" @endif>Zoroastrianism</option>
                <option value="Other" @if (old('belief') == 'Other') selected="selected" @endif>Other</option>
            </select>

            {!! Form::select('beacon_tag', $beacons) !!}

            <select name = 'source' required>
                <option value="" disabled selected>Source:</option>
                <option value="Discussion" @if (old('source') == 'Discussion') selected="selected" @endif>Discussion</option>
                <option value="Reflection" @if (old('source') == 'Reflection') selected="selected" @endif>Reflection</option>
                <option value="Writings" @if (old('source') == 'Writings') selected="selected" @endif>Writings</option>
                <option value="Nature" @if (old('source') == 'Nature') selected="selected" @endif>Nature</option>
                <option value="Other" @if (old('source') == 'Other') selected="selected" @endif>Other</option>
            </select>
        </div>
    </div>

    <!-- Body Form Input -->

    <div class = "indexContent" id = "imageUpload">
        <a href = "{{ url('/images') }}" target = "blank">View Image Guidelines</a>
        {!! Form::file('image', null, ['class' => 'navButton']) !!}
        {!! Form::textarea('caption', null, ['id' => 'createBodyText', 'placeholder' => 'Add optional caption:', 'rows' => '2%', 'maxlength' => '255']) !!}
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