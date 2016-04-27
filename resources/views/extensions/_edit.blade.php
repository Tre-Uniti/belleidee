@section('pageHeader')
    <script src = "/js/extension.js"></script>
@stop
<div id = "createOptions">
    @if(isset($sources['extenception']))
        <p><button type = "button" class = "interactButton" id = "content">Show Source Text</button></p>
        <div class = "extensionContent" id = "hiddenContent">{!! nl2br(e($content)) !!}
            <p>Created by: <a href = "{{ url('/users/'. $sourceUser['id']) }}" target="_blank">{{ $sourceUser['handle'] }}</a></p></div>
    @elseif(isset($sources['post_id']))
        <p><button type = "button" class = "interactButton" id = "content">Show Source Text</button></p>
        <div class = "extensionContent" id = "hiddenContent">{!! nl2br(e($content)) !!}
            <p>Created by: <a href = "{{ url('/users/'. $sourceUser['id']) }}" target="_blank">{{ $sourceUser['handle'] }}</a></p></div>
    @elseif(isset($sources['question_id']))
        <p><button type = "button" class = "interactButton" id = "content">Show Source Text</button></p>
        <div class = "extensionContent" id = "hiddenContent">
            {!! nl2br(e($content)) !!}
            <p>Created by: <a href = "{{ url('/users/'. $sourceUser['id']) }}" target="_blank">{{ $sourceUser['handle'] }}</a></p></div>
    @endif

    <div class = "formInput">
            {!! Form::text('title', null, ['class' => 'createTitleText', 'autofocus']) !!}
        </div>

            <div class = "formInput">
                <select name = 'belief' required >
                    <option value="" disabled selected>Belief or Way:</option>
                    <option value="Adaptia" @if (old('belief') == 'Adaptia') selected="selected" @elseif($extension->belief == 'Adaptia' & (old('belief') == '')) selected="selected" @endif>Adaptia</option>
                    <option value="Atheism" @if (old('belief') == 'Atheism') selected="selected" @elseif($extension->belief == 'Atheism' & (old('belief') == '')) selected="selected" @endif>Atheism</option>
                    <option value="Buddhism" @if (old('belief') == 'Buddhism') selected="selected" @elseif($extension->belief == 'Buddhism' & (old('belief') == '')) selected="selected" @endif>Buddhism</option>
                    <option value="Christianity" @if (old('belief') == 'Christianity') selected="selected" @elseif($extension->belief == 'Christianity' & (old('belief') == '')) selected="selected" @endif>Christianity</option>
                    <option value="Druze" @if (old('belief') == 'Druze') selected="selected" @elseif($extension->belief == 'Druze' & (old('belief') == '')) selected="selected" @endif>Druze</option>
                    <option value="Hinduism" @if (old('belief') == 'Hinduism') selected="selected" @elseif($extension->belief == 'Hinduism' & (old('belief') == '')) selected="selected" @endif>Hinduism</option>
                    <option value="Islam" @if (old('belief') == 'Islam') selected="selected" @elseif($extension->belief == 'Islam' & (old('belief') == '')) selected="selected" @endif>Islam</option>
                    <option value="Indigenous" @if (old('belief') == 'Indigenous') selected="selected" @elseif($extension->belief == 'Indigenous' & (old('belief') == '')) selected="selected" @endif>Indigenous</option>
                    <option value="Judaism" @if (old('belief') == 'Judaism') selected="selected" @elseif($extension->belief == 'Judaism' & (old('belief') == '')) selected="selected" @endif>Judaism</option>
                    <option value="Shinto" @if (old('belief') == 'Shinto') selected="selected" @elseif($extension->belief == 'Shinto' & (old('belief') == '')) selected="selected" @endif>Shinto</option>
                    <option value="Sikhism" @if (old('belief') == 'Sikhism') selected="selected" @elseif($extension->belief == 'Sikhism' & (old('belief') == '')) selected="selected" @endif>Sikhism</option>
                    <option value="Taoism" @if (old('belief') == 'Taoism') selected="selected" @elseif($extension->belief == 'Taoism'& (old('belief') == '')) selected="selected" @endif>Taoism</option>
                    <option value="Urantia" @if (old('belief') == 'Urantia') selected="selected" @elseif($extension->belief == 'Urantia' & (old('belief') == '')) selected="selected" @endif>Urantia</option>
                    <option value="Zoroastrianism" @if (old('belief') == 'Zoroastrianism') selected="selected" @elseif($extension->belief == 'Zoroastrianism' & (old('belief') == '')) selected="selected" @endif>Zoroastrianism</option>
                    <option value="Other" @if (old('belief') == 'Other') selected="selected" @elseif($extension->belief == 'Other' & (old('belief') == '')) selected="selected" @endif>Other</option>
                </select>


                {!! Form::select('beacon_tag', $beacons) !!}


                <select name = 'source' required>
                    <option  disabled>Source:</option>
                    @if(isset($sources['extenception']))
                        <option value="Extension" @if (old('source') == 'Extension') selected="selected" @elseif($extension->source == 'Extension' & (old('category') == '')) selected="selected" @endif>Extension</option>
                    @elseif(isset($sources['post_id']))
                        <option value="Post" @if (old('source') == 'Post') @elseif($extension->source == 'Post' & (old('category') == '')) selected="selected" @endif>Post</option>
                    @elseif(isset($sources['question_id']))
                        <option value="Question" @if (old('source') == 'Question') selected="selected" @elseif($extension->source == 'Question' & (old('category') == '')) @endif>Question</option>
                    @endif
                </select>
        </div>

    <!-- Body Form Input -->
        @if(($sources['type'] == 'question'))
            {!! Form::textarea('body', null, ['id' => 'createBodyText', 'placeholder' => 'Answer the question here:', 'rows' => '17%', 'maxlength' => '3500']) !!}
        @else
            {!! Form::textarea('body', null, ['id' => 'createBodyText', 'placeholder' => 'Continue your extension here:', 'rows' => '17%', 'maxlength' => '3500']) !!}
        @endif
        @section('centerFooter')
            @if(($sources['type'] == 'question'))
                {!! Form::submit('Update Answer', ['class' => 'navButton']) !!}
            @else
                {!! Form::submit($submitButtonText, ['class' => 'navButton']) !!}
            @endif
            <a href="{{ URL::previous() }}"><button type = "button" id = "cancel" class = "navButton">Cancel</button></a>
        @stop
</div>