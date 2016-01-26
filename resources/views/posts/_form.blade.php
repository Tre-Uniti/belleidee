<div id = "createOptions">

<table align = "center" style = "margin-bottom: 7px;">
    <tr>
        <th colspan="3" style = "border-color: #E8E8E8;">{!! Form::label('title', 'Post Title:') !!}</th>
    </tr>
    <tr>
        <td colspan="3" style = "border-color: #E8E8E8;">{!! Form::text('title', null, ['class' => 'createTitleText', 'autofocus']) !!}</td>
    </tr>
    <tr>
        <td style = "border-color: #E8E8E8;">
            <select name = 'belief' required >
                <option value="" disabled selected hidden>Belief:</option>
                <option value="Adaptia" @if (old('belief') == 'Adaptia') selected="selected" @endif>Adaptia</option>
                <option value="Atheism" @if (old('belief') == 'Atheism') selected="selected" @endif>Atheism</option>
                <option value="Ba Gua"  @if (old('belief') == 'Ba Gua') selected="selected" @endif>Ba Gua</option>
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
                <option value="Other" @if (old('belief') == 'Other') selected="selected" @endif>Other</option>
            </select>
        </td>
        <td style = "border-color: #E8E8E8;">
            {!! Form::select('beacon_tag', $beacons) !!}
        </td>
        <td style = "border-color: #E8E8E8;">
            <select name = 'category' required>
                <option value="" disabled selected hidden>Category:</option>
                <option value="Opinion" @if (old('category') == 'Opinion') selected="selected" @endif>Opinion</option>
                <option value="Poem" @if (old('category') == 'Poem') selected="selected" @endif>Poem</option>
                <option value="Prayer" @if (old('category') == 'Prayer') selected="selected" @endif>Prayer</option>
                <option value="Reflection" @if (old('category') == 'Reflection') selected="selected" @endif>Reflection</option>
                <option value="Scholar" @if (old('category') == 'Scholar') selected="selected" @endif>Scholar</option>
                <option value="Story" @if (old('category') == 'Story') selected="selected" @endif>Story</option>
                <option value="Other" @if (old('category') == 'Other') selected="selected" @endif>Other</option>
            </select>
        </td>
    </tr>
</table>

<!-- Body Form Input -->
    <div id = "centerTextContent">
    {!! Form::textarea('body', null, ['id' => 'createBodyText', 'placeholder' => 'Express your belief here:', 'rows' => '19', 'maxlength' => '3500']) !!}
    </div>
    @section('centerFooter')
        {!! Form::submit($submitButtonText, ['class' => 'navButton', 'id' => 'submit']) !!}
        <a href="{{ URL::previous() }}"><button type = "button" id = "cancel" class = "navButton">Cancel</button></a>
    {!! Form::close()   !!}
    @stop

</div>