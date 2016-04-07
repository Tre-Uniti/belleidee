<div id = "createOptions">
    @if(isset($sources['extenception']))
        <p>Extension of: <a href = {{ action('ExtensionController@show', [$sources['extenception']])}}> {{ $sources['extension_title'] }}</a></p>
    @elseif(isset($sources['post_id']))
        <p>Extension of: <a href = {{ action('PostController@show', [$sources['post_id']])}}> {{ $sources['post_title'] }}</a></p>
    @elseif(isset($sources['question_id']))
        <p>Answer to: <a href = {{ action('QuestionController@show', [$sources['question_id']])}}> {{ $sources['question'] }}</a></p>
    @endif

        <table align = "center" style = "margin-bottom: 7px;">
            <tr>
                <td colspan="3" style = "border-color: #E8E8E8;">{!! Form::text('title', null, ['class' => 'createTitleText', 'autofocus', 'placeholder' => 'Your Extension Title']) !!}</td>
            </tr>
        </table>
        <div style = "width: 100%; padding-bottom: 3px;">

            <select name = 'belief' required >
                <option value="" disabled selected>Belief:</option>
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



            {!! Form::select('beacon_tag', $beacons) !!}
            <select name = 'source' required>
                <option  disabled>Source:</option>
                @if(isset($sources['extenception']))
                    <option value="Extension" @if (old('source') == 'Extension') selected="selected" @endif>Extension</option>
                @elseif(isset($sources['post_id']))
                    <option value="Post" @if (old('source') == 'Post') selected="selected" @endif>Post</option>
                @elseif(isset($sources['question_id']))
                    <option value="Question" @if (old('source') == 'Question') selected="selected" @endif>Question</option>
                @endif
            </select>
        </div>

<!-- Body Form Input -->
    <div id = "centerTextContent">
        @if(($sources['type'] == 'question'))
            {!! Form::textarea('body', null, ['id' => 'createBodyText', 'placeholder' => 'Answer the question here:', 'rows' => '17%', 'maxlength' => '3500']) !!}
        @else
            {!! Form::textarea('body', null, ['id' => 'createBodyText', 'placeholder' => 'Continue your extension here:', 'rows' => '17%', 'maxlength' => '3500']) !!}
        @endif

    </div>
    @section('centerFooter')
        @if(($sources['type'] == 'question'))
            {!! Form::submit('Answer', ['class' => 'navButton']) !!}
        @else
            {!! Form::submit($submitButtonText, ['class' => 'navButton']) !!}
        @endif
    <a href="{{ URL::previous() }}"><button type = "button" id = "cancel" class = "navButton">Cancel</button></a>
    @stop
</div>