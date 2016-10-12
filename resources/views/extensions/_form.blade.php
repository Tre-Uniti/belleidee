@section('pageHeader')
    <script src = "/js/caffeine.js"></script>
    <script src = "/js/toggleSource.js"></script>
    <script src = "/js/submit.js"></script>
    <script src = "/js/creation.js"></script>
    <link href="/css/lightbox.css" rel="stylesheet">
@stop

    @if(isset($sources['question_id']) && (!isset($sources['extenception'])))
        <p><button type = "button" class = "interactButton" id = "content">Answer to: {{ $sourceModel->question }}</button></p>
    @else
        <p><button type = "button" class = "interactButton" id = "content">Extends: {{ $sourceModel->title }}</button></p>
    @endif

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
            {!! nl2br(e($content)) !!}
            <p>Legacy of: <a href = "{{ url('/beliefs/'. $sourceUser['belief']) }}" target="_blank">{{ $sourceUser['belief'] }}</a></p>
        @endif
    </div>
    <button class = "interactButton" type = "button" id = "hiddenIndex">Show Tags</button>
    <div class = "indexContent" id = "hiddenIndexContent">
        <div class = "formData">
            <div class = "formCreation">
                <div class = "tagLabel">Belief or Way:</div>
                <div>
                    <select name = 'belief' class = "tagSelector" required >
                        <option value="Adaptia" @if (old('belief') == 'Adaptia') selected="selected" @elseif($lastBeacon->belief == 'Adaptia' & (old('belief') == '')) selected="selected" @endif>Adaptia</option>
                        <option value="Atheism" @if (old('belief') == 'Atheism') selected="selected" @elseif($lastBeacon->belief == 'Atheism' & (old('belief') == '')) selected="selected" @endif>Atheism</option>
                        <option value="Bahá’í" @if (old('belief') == 'Bahá’í') selected="selected" @elseif($lastBeacon->belief == 'Bahá’í' & (old('belief') == '')) selected="selected" @endif>Bahá’í</option>
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
                    <div class = "tagLabel">Beacon Tag:</div>
                    <div>
                        {!! Form::select('beacon_tag', $beacons, $beacon->beacon_tag, ['class' => 'tagSelector']) !!}
                    </div>
                    </div>
            <select name = 'source' class = 'tagSelector' required hidden>
                    <option value="Post" @if (old('source') == 'Post') selected="selected" @endif>Post</option>
            </select>
        </div>
        </div>

<!-- Body Form Input -->
    <div id = "centerTextContent">
            {!! Form::textarea('body', null, ['id' => 'createBodyText', 'placeholder' => 'Add your extension here:', 'rows' => '7%', 'maxlength' => '3500']) !!}

    </div>
    {!! Form::submit($submitButtonText, ['class' => 'navButton', 'id' => 'submit']) !!}

        <script src="/js/lightbox.js"></script>


<div class = "contentHeaderSeparator">
    <h3>Extensions</h3>

</div>
<div id = "otherExtensions">
    @if(count($extensions) == 0)
        <p>Be the first to extend!</p>
        @else
        @foreach ($extensions as $extension)
            <div class = "contentExtensionCard">
                <div class = "cardTitleSection">
                    <h3>
                        <a href="{{ action('ExtensionController@show', [$extension->id])}}">{{ $extension->title }}</a>
                    </h3>

                </div>
                <div class = "cardHandleSection">
                    <p>
                        By: <a href="{{ action('UserController@show', [$extension->user_id])}}" class = "contentHandle">{{ $extension->user->handle }}</a> on <a href = {{ url('/extensions/date/'.$extension->created_at->format('M-d-Y')) }}>{{ $extension->created_at->format('M-d-Y') }}</a>
                    </p>
                    <p>
                        @if(isset($extension->extenception))
                            Extends: <a href = "{{ url('/extensions/' . $extension->extenception) }}">{{ $extension->extenceptionTitle($extension->extenception) }}</a>
                        @elseif(isset($extension->post_id))
                            Extends: <a href = "{{ url('/posts/' . $extension->post_id) }}">{{ $extension->post->title }}</a>
                        @elseif(isset($extension->question_id))
                            Answers: <a href = "{{ url('/questions/' . $extension->question_id) }}">{{ $extension->question->question }}</a>
                        @elseif(isset($extension->question_id))
                            Extends: <a href = "{{ url('/legacyPosts/' . $extension->legacy_post_id) }}">{{ $extension->legacyPost->title }}</a>
                        @endif
                    </p>
                </div>
                <div class = "cardCaptionExcerptSection">
                    <p class = "cardExcerpt">
                        {{ $extension->excerpt }}<a href="{{ action('ExtensionController@show', [$extension->id])}}">... Read More</a>
                    </p>
                </div>

                <div class = "influenceSection">
                    <div class = "elevationSection">
                        <div class = "elevationIcon">
                            @if($extension->elevateStatus === 'Elevated')
                                <i class="fa fa-heart fa-lg" aria-hidden="true"></i>
                            @else
                                <a href="{{ url('/extensions/elevate/'.$extension->id) }}" class = "iconLink"><i class="fa fa-heart-o fa-lg" aria-hidden="true"></i></a>
                            @endif
                            <span class="tooltiptext">Heart to give thanks and recommend to others</span>
                        </div>
                        <div class = "elevationCounter">
                            <a href={{ url('/extensions/listElevation/'.$extension->id)}}>{{ $extension->elevation }}</a>
                        </div>
                    </div>

                    <div class = "beaconSection">
                        <a href="{{ url('/beacons/'.$extension->beacon_tag) }}">{{ $extension->beacon_tag }}</a>
                        <span class="tooltiptext">Beacon community where this post is located</span>
                    </div>

                    <div class = "extensionSection">
                        <a href="{{ url('/extensions/extenception/'.$extension->id) }}" class = "iconLink"><i class="fa fa-comments-o fa-lg" aria-hidden="true"></i></a>
                        <a href={{ url('/extensions/extend/list/'.$extension->id)}}>{{ $extension->extension }}</a>
                        <span class="tooltiptext">Extend to add any inspiration you received</span>
                    </div>
                    <div class = "moreSection">
                        <p class = "moreOptions"><i class="fa fa-angle-up fa-lg" aria-hidden="true"></i></p>
                        <div class="moreOptionsMenu">
                            <a href="{{ url('bookmarks/extensions/'.$extension->id) }}"><i class="fa fa-bookmark-o fa-lg" aria-hidden="true"></i></a>
                            <a href="https://www.facebook.com/share.php?u={{Request::url()}}&title={{$extension->title}}" target="_blank"><i class="fa fa-facebook-square fa-lg" aria-hidden="true"></i></a>
                            <a href="https://twitter.com/intent/tweet?status={{$extension->title}} - {{Request::url()}}" target="_blank"><i class="fa fa-twitter-square fa-lg" aria-hidden="true"></i></a>
                            <a href="https://plus.google.com/share?url={{Request::url()}}" target="_blank"><i class="fa fa-google-plus-square fa-lg" aria-hidden="true"></i></a>
                            @if($extension->user_id != Auth::id())
                                <a href="{{ url('/intolerances/extension/'.$extension->id) }}"><i class="fa fa-flag-o fa-lg" aria-hidden="true"></i></a>
                            @elseif ($extension->status < 1)
                                Status: Tolerant
                            @else
                                Status: Intolerant
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        @endif
</div>