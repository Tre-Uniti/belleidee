@section('pageHeader')
    <script src = "/js/caffeine.js"></script>
    <script src = "/js/toggleSource.js"></script>
    <script src = "/js/submit.js"></script>
    <script src = "/js/creation.js"></script>
    <link href="/css/lightbox.css" rel="stylesheet">
@stop
<div>
    @if(isset($sources['question_id']) && (!isset($sources['extenception'])))
        <h3>Answer to: <a href = "{{ url('/questions/' . $sources['question_id']) }}">{{ $sourceModel->question }}</a></h3>
    @else
        <h3>Extends:

            @if(isset($sources['post_id']))
                <a href = "{{ url('/posts/' . $sources['post_id'] ) }}">{{ $sourceModel->title }}</a>
            @elseif(isset($sources['legacy_id']))
                <a href = "{{ url('/legacyPosts/' . $sourceModel->id ) }}">{{ $sourceModel->title }}</a>
            @else
                <a href = "{{ url('/extensions/' . $sources['extenception']) }}">An Extension</a>
            @endif
        </h3>
    @endif
</div>
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
                <p>{{$sourceModel->caption}}</p>
                <div class = "postPhoto">
                    <a href="{{ url(env('IMAGE_LINK'). $sourceOriginalPath) }}" data-lightbox="{{ $sourceModel->title }}" data-title="{{ $sourceModel->caption }}"><img src= {{ url(env('IMAGE_LINK'). $sourceModel->post_path) }} alt="{{$sourceModel->title}}" width="99%" height="99%"></a>
                </div>
            </div>
        @else
            {!! nl2br(e($content)) !!}
        @endif
        <p>Created by: <a href = "{{ url('/users/'. $sourceUser['id']) }}" target="_blank">{{ $sourceUser['handle'] }}</a></p>

    @elseif(isset($sources['question_id']))
        {!! nl2br(e($content)) !!}
        <p>Asked by: <a href = "{{ url('/users/'. $sourceUser['id']) }}" target="_blank">{{ $sourceUser['handle'] }}</a></p>

    @elseif(isset($sources['legacy_id']))
        @if($type != 'txt')
            <div class = "photoContent">
                <p>{{$sourceModel->caption}}</p>
                <div class = "postPhoto">
                    <a href="{{ url(env('IMAGE_LINK'). $sourceModel->original_source_path) }}" data-lightbox="{{ $sourceModel->title }}" data-title="{{ $sourceModel->caption }}"><img src= {{ url(env('IMAGE_LINK'). $sourceModel->source_path) }} alt="{{$sourceModel->title}}" width="99%" height="99%"></a>
                </div>
            </div>
        @else
            {!! nl2br(e($content)) !!}
        @endif        <p>Legacy of: <a href = "{{ url('/beliefs/'. $sourceUser['belief']) }}" target="_blank">{{ $sourceUser['belief'] }}</a></p>
    @endif
</div>
<div class = "newExtension">
<!-- Body Form Input -->
    <div id = "centerTextContent">
        @if(($sources['type'] == 'question'))
            {!! Form::textarea('body', null, ['id' => 'createBodyText', 'placeholder' => 'Answer the question here:', 'rows' => '7%', 'maxlength' => '3500']) !!}
        @else
            {!! Form::textarea('body', null, ['id' => 'createBodyText', 'placeholder' => 'Add your extension here:', 'rows' => '7%', 'maxlength' => '3500']) !!}
        @endif
    </div>
    <div class = "indexContent" id = "hiddenIndexContent">
        <div class = "formData">
            <div class = "formCreation">
                <div class = "tagLabel">Belief or Way:</div>
                <div>
                    <select name = 'belief' class = "tagSelector" required >
                        <option value="" disabled selected>Belief or Way:</option>
                        <option value="Adaptia" @if (old('belief') == 'Adaptia') selected="selected" @elseif($extension->belief == 'Adaptia' & (old('belief') == '')) selected="selected" @endif>Adaptia</option>
                        <option value="Atheism" @if (old('belief') == 'Atheism') selected="selected" @elseif($extension->belief == 'Atheism' & (old('belief') == '')) selected="selected" @endif>Atheism</option>
                        <option value="Bahá’í" @if (old('belief') == 'Bahá’í') selected="selected" @elseif($extension->belief == 'Bahá’í' & (old('belief') == '')) selected="selected" @endif>Bahá’í</option>
                        <option value="Buddhism" @if (old('belief') == 'Buddhism') selected="selected" @elseif($extension->belief == 'Buddhism' & (old('belief') == '')) selected="selected" @endif>Buddhism</option>
                        <option value="Christianity" @if (old('belief') == 'Christianity') selected="selected" @elseif($extension->belief == 'Christianity' & (old('belief') == '')) selected="selected" @endif>Christianity</option>
                        <option value="Druze" @if (old('belief') == 'Druze') selected="selected" @elseif($extension->belief == 'Druze' & (old('belief') == '')) selected="selected" @endif>Druze</option>
                        <option value="Hinduism" @if (old('belief') == 'Hinduism') selected="selected" @elseif($extension->belief == 'Hinduism' & (old('belief') == '')) selected="selected" @endif>Hinduism</option>
                        <option value="Islam" @if (old('belief') == 'Islam') selected="selected" @elseif($extension->belief == 'Islam' & (old('belief') == '')) selected="selected" @endif>Islam</option>
                        <option value="Indigenous" @if (old('belief') == 'Indigenous') selected="selected" @elseif($extension->belief == 'Indigenous' & (old('belief') == '')) selected="selected" @endif>Indigenous</option>
                        <option value="Jainism" @if (old('belief') == 'Jainism') selected="selected" @elseif($extension->belief == 'Jainism' & (old('belief') == '')) selected="selected" @endif>Jainism</option>
                        <option value="Judaism" @if (old('belief') == 'Judaism') selected="selected" @elseif($extension->belief == 'Judaism' & (old('belief') == '')) selected="selected" @endif>Judaism</option>
                        <option value="Shinto" @if (old('belief') == 'Shinto') selected="selected" @elseif($extension->belief == 'Shinto' & (old('belief') == '')) selected="selected" @endif>Shinto</option>
                        <option value="Sikhism" @if (old('belief') == 'Sikhism') selected="selected" @elseif($extension->belief == 'Sikhism' & (old('belief') == '')) selected="selected" @endif>Sikhism</option>
                        <option value="Taoism" @if (old('belief') == 'Taoism') selected="selected" @elseif($extension->belief == 'Taoism'& (old('belief') == '')) selected="selected" @endif>Taoism</option>
                        <option value="Urantia" @if (old('belief') == 'Urantia') selected="selected" @elseif($extension->belief == 'Urantia' & (old('belief') == '')) selected="selected" @endif>Urantia</option>
                        <option value="Zoroastrianism" @if (old('belief') == 'Zoroastrianism') selected="selected" @elseif($extension->belief == 'Zoroastrianism' & (old('belief') == '')) selected="selected" @endif>Zoroastrianism</option>
                        <option value="Other" @if (old('belief') == 'Other') selected="selected" @elseif($extension->belief == 'Other' & (old('belief') == '')) selected="selected" @endif>Other</option>
                    </select>
                </div>
            </div>
            <div class = "formCreation">
                <div class = "tagLabel">Beacon Tag:</div>
                <div>
                    {!! Form::select('beacon_tag', $beacons, $extension->beacon_tag, ['class' => 'tagSelector']) !!}
                </div>
            </div>
        </div>
    </div>
    @if(isset($sources['extenception']))
        @if(isset($sourceModel->question_id))
            <input type="hidden" name="original" value="Question">
            <input type="hidden" name="original_id" value="{{ $sourceModel->question_id }}">
        @elseif(isset($sourceModel->legacy_post_id))
            <input type="hidden" name="original" value="Legacy">
            <input type="hidden" name="original_id" value="{{ $sourceModel->legacy_post_id }}">
        @elseif(isset($sourceModel->post_id))
            <input type="hidden" name="original" value="Post">
            <input type="hidden" name="original_id" value="{{ $sourceModel->post_id }}">
        @endif
        <input type="hidden" name="type" value="Extenception">
        <input type="hidden" name="id" value="{{ $sourceModel->id }}">
    @elseif(isset($sources['post_id']))
        <input type="hidden" name="type" value="Post">
        <input type="hidden" name="id" value="{{ $sourceModel->id }}">
    @elseif(isset($sources['question_id']))
        <input type="hidden" name="type" value="Question">
        <input type="hidden" name="id" value="{{ $sourceModel->id }}">
    @elseif(isset($sources['legacy_id']))
        <input type="hidden" name="type" value="Legacy">
        <input type="hidden" name="id" value="{{ $sourceModel->id }}">
    @endif
    <div>
        <button class = "interactButton" type = "button" id = "hiddenIndex">Tags</button>
            @if(($sources['type'] == 'question'))
                {!! Form::submit('Update', ['class' => 'navButton', 'id' => 'submit']) !!}
            @else
                {!! Form::submit($submitButtonText, ['class' => 'navButton', 'id' => 'submit']) !!}
            @endif
            <a href="{{ URL::previous() }}"><button type = "button" id = "cancel" class = "navButton">Cancel</button></a>
        {!! Form::close()   !!}
        <button type = "button" class = "interactButton" id = "content">Source</button>
    </div>
</div>