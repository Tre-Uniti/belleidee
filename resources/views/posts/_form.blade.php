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
            {!! Form::label('title', 'Title:') !!}
        </div>
        <div class = "formData">
            {!! Form::text('title', null, ['class' => 'createTitleText', 'autofocus']) !!}
        </div>
        <button class = "interactButton" type = "button" id = "hiddenIndex">Show Tags</button>
        <div class = "indexContent" id = "hiddenIndexContent">
            <div class = "formData">
                <div class = "formCreation">
                    <div>Belief or Way:</div>
                    <div>
                        <select name = 'belief' required >
                            <option value="Adaptia" @if (old('belief') == 'Adaptia') selected="selected" @elseif($lastBeacon->belief == 'Adaptia' & (old('belief') == '')) selected="selected" @endif>Adaptia</option>
                            <option value="Atheism" @if (old('belief') == 'Atheism') selected="selected" @elseif($lastBeacon->belief == 'Atheism' & (old('belief') == '')) selected="selected" @endif>Atheism</option>
                            <option value="Buddhism" @if (old('belief') == 'Buddhism') selected="selected" @elseif($lastBeacon->belief == 'Buddhism' & (old('belief') == '')) selected="selected" @endif>Buddhism</option>
                            <option value="Christianity" @if (old('belief') == 'Christianity') selected="selected" @elseif($lastBeacon->belief == 'Christianity' & (old('belief') == '')) selected="selected" @endif>Christianity</option>
                            <option value="Druze" @if (old('belief') == 'Druze') selected="selected" @elseif($lastBeacon->belief == 'Druze' & (old('belief') == '')) selected="selected" @endif>Druze</option>
                            <option value="Hinduism" @if (old('belief') == 'Hinduism') selected="selected" @elseif($lastBeacon->belief == 'Hinduism' & (old('belief') == '')) selected="selected" @endif>Hinduism</option>
                            <option value="Islam" @if (old('belief') == 'Islam') selected="selected" @elseif($lastBeacon->belief == 'Islam' & (old('belief') == '')) selected="selected" @endif>Islam</option>
                            <option value="Indigenous" @if (old('belief') == 'Indigenous') selected="selected" @elseif($lastBeacon->belief == 'Indigenous' & (old('belief') == '')) selected="selected" @endif>Indigenous</option>
                            <option value="Judaism" @if (old('belief') == 'Judaism') selected="selected" @elseif($lastBeacon->belief == 'Judaism' & (old('belief') == '')) selected="selected" @endif>Judaism</option>
                            <option value="Shinto" @if (old('belief') == 'Shinto') selected="selected" @elseif($lastBeacon->belief == 'Shinto' & (old('belief') == '')) selected="selected" @endif>Shinto</option>
                            <option value="Sikhism" @if (old('belief') == 'Sikhism') selected="selected" @elseif($lastBeacon->belief == 'Sikhism' & (old('belief') == '')) selected="selected" @endif>Sikhism</option>
                            <option value="Taoism" @if (old('belief') == 'Taoism') selected="selected" @elseif($lastBeacon->belief == 'Taoism'& (old('belief') == '')) selected="selected" @endif>Taoism</option>
                            <option value="Urantia" @if (old('belief') == 'Urantia') selected="selected" @elseif($lastBeacon->belief == 'Urantia' & (old('belief') == '')) selected="selected" @endif>Urantia</option>
                            <option value="Zoroastrianism" @if (old('belief') == 'Zoroastrianism') selected="selected" @elseif($lastBeacon->belief == 'Zoroastrianism' & (old('belief') == '')) selected="selected" @endif>Zoroastrianism</option>
                            <option value="Other" @if (old('belief') == 'Other') selected="selected" @elseif($lastBeacon->belief == 'Other' & (old('belief') == '')) selected="selected" @endif>Other</option>
                        </select>
                    </div>
                </div>
                <div class = "formCreation">
                    <div>Beacon Tag:</div>
                    <div>
                        {!! Form::select('beacon_tag', $beacons, $lastBeacon->beacon_tag) !!}
                    </div>
                </div>
                <div class = "formCreation">
                    <div>Source:</div>
                    <div>
                        <select name = 'source' required>
                            <option value="Discussion" @if (old('source') == 'Discussion') selected="selected" @endif>Discussion</option>
                            <option value="Reflection" @if (old('source') == 'Reflection') selected="selected" @endif>Reflection</option>
                            <option value="Writings" @if (old('source') == 'Writings') selected="selected" @endif>Writings</option>
                            <option value="Nature" @if (old('source') == 'Nature') selected="selected" @endif>Nature</option>
                            <option value="Other" @if (old('source') == 'Other') selected="selected" @endif>Other</option>
                        </select>
                    </div>
                </div>
        </div>
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