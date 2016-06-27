@section('pageHeader')
    <script src = "/js/caffeine.js"></script>
    <script src = "/js/toggleSource.js"></script>
    <script src = "/js/submit.js"></script>
    <script src = "/js/creation.js"></script>
    <link href="/css/lightbox.css" rel="stylesheet">
@stop

<div id = "createOptions">
    <p><button type = "button" class = "interactButton" id = "content">Show Source</button></p>
    <div class = "extensionContent" id = "hiddenContent">
    @if(isset($sources['extenception']))
            @if($type != 'txt')
                <div class = "photoContent">
                    <a href = "{{ url('/extensions/'. $sourceModel->id) }}" target = "_blank"><img src= {{ url(env('IMAGE_LINK'). $sourceModel->extension_path) }} alt="{{$sourceModel->title}}"></a>
                </div>
            @else
                {!! nl2br(e($content)) !!}
            @endif
            <p>Created by: <a href = "{{ url('/users/'. $sourceUser['id']) }}" target="_blank">{{ $sourceUser['handle'] }}</a></p>
    @elseif(isset($sources['post_id']))
            @if($type != 'txt')
                <div class = "photoContent">
                    <a href="{{ url(env('IMAGE_LINK'). $sourceOriginalPath) }}" data-lightbox="{{ $sourceModel->title }}" data-title="{{ $sourceModel->caption }}"><img src= {{ url(env('IMAGE_LINK'). $sourceModel->post_path) }} alt="{{$sourceModel->title}}"></a>
                    <p>{{$sourceModel->caption}}</p>
                </div>
            @else
                {!! nl2br(e($content)) !!}
            @endif
            <p>Created by: <a href = "{{ url('/users/'. $sourceUser['id']) }}" target="_blank">{{ $sourceUser['handle'] }}</a></p>

    @elseif(isset($sources['question_id']))
            {!! nl2br(e($content)) !!}
            <p>Created by: <a href = "{{ url('/users/'. $sourceUser['id']) }}" target="_blank">{{ $sourceUser['handle'] }}</a></p>
    @endif
    </div>
        <div class = "formData">
            {!! Form::text('title', null, ['class' => 'createTitleText', 'autofocus', 'placeholder' => 'Your Title']) !!}
            </div>
        <div class = "formInput">
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
            {!! Form::submit('Answer', ['class' => 'navButton', 'id' => 'submit']) !!}
        @else
            {!! Form::submit($submitButtonText, ['class' => 'navButton', 'id' => 'submit']) !!}
        @endif
    <a href="{{ URL::previous() }}"><button type = "button" id = "cancel" class = "navButton">Cancel</button></a>
            <script src="/js/lightbox.js"></script>
    @stop
</div>