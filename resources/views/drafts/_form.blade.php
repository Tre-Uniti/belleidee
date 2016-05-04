<div id = "createOptions">
    <div class = "formInput">
        <b>{!! Form::label('title', 'Draft Title:') !!}</b>
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

<!-- Body Form Input -->
    <div id = "centerTextContent">
    {!! Form::textarea('body', null, ['id' => 'createBodyText', 'placeholder' => 'Create your draft here:', 'rows' => '18', 'maxlength' => '3500']) !!}
    </div>
    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" class = "navButton">Cancel</button></a>
    {!! Form::close()   !!}
    @stop

</div>