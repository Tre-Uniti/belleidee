@extends('app')
@section('pageHeader')
    <script src = "/js/caffeine.js"></script>
    <script src = "/js/toggleSource.js"></script>
    <script src = "/js/submit.js"></script>
    <script src = "/js/creation.js"></script>
    <link href="/css/lightbox.css" rel="stylesheet">

    <!-- You can use Open Graph tags to customize link previews.
Learn more: https://developers.facebook.com/docs/sharing/webmasters -->
    <meta property="og:url"           content= "{{ Request::url() }}"/>
    <meta property="og:type"          content="website"/>
    <meta property="og:title"         content="Belle-Idee"/>
    <meta property="og:description"   content="{{ $post->title }}"/>
    @if($type != 'txt')
        <meta property="og:image"         content="{{ url(env('IMAGE_LINK'). $post->post_path) }}"/>
    @elseif(isset($sourcePhotoPath) && $sourcePhotoPath != NULL)
        <meta property="og:image"         content="{{ url(env('IMAGE_LINK'). $sourcePhotoPath) }}"/>
    @elseif(isset($photoPath) && $photoPath != NULL)
        <meta property="og:image"         content="{{ url(env('IMAGE_LINK'). $photoPath) }}"/>
    @else
        <meta property="og:image"         content={{ url('/img/idee-med.png') }}/>
    @endif
@stop
@section('siteTitle')
    Show Post
@stop

@section('centerText')
    <div id="fb-root"></div>
    <div id = "postContent">
<article>
    <header>
        <h1>{{ $post->title }}</h1>
    </header>

    <h4>By: <a href = "{{ url('/users/'. $post->user->id) }}" class = "contentHandle">{{ $post->user->handle }}</a> on <a href = {{ url('/posts/date/'.$post->created_at->format('M-d-Y')) }}>{{ $post->created_at->format('M-d-Y')  }}</a></h4>
    <div class = "indexNav">
        <div class = "beliefIndex">
            <a href="{{ action('BeliefController@show', $post->belief) }}"><i class="fa fa-hashtag" aria-hidden="true"></i>{{ $post->belief }}</a>
            <span class="tooltiptext">Belief or way of life related to the post</span>
        </div>
        <div class = "sourceIndex">
            <a href="{{ url('/posts/source/'. $post->source) }}"><i class="fa fa-hashtag" aria-hidden="true"></i>{{ $post->source }}</a>
            <span class="tooltiptext">Source where the post came from</span>
        </div>
    </div>

    @if($type != 'txt')
        <div class = "photoContent">
            <p>{!! nl2br($post->caption) !!}</p>
            <div class = "postPhoto">
                <a href="{{ url(env('IMAGE_LINK'). $sourceOriginalPath) }}" data-lightbox="{{ $post->title }}" data-title="{{ $post->caption }}"><img src= {{ url(env('IMAGE_LINK'). $post->post_path) }} alt="{{$post->title}}" width = "99%" height = "99%"></a>
            </div>
        </div>
        @else
        <div id = "centerTextContent">
            <p class = "textContent">
                {!! nl2br($post->body) !!}
            </p>
        </div>
    @endif
</article>
    </div>
    <div id = "postDetails">
        <div class = "footerSection">
            <div class = "leftSection">
                <div class = "leftIcon">
                    @if($post->elevateStatus === 'Elevated')
                        <i class="fa fa-heart fa-lg" aria-hidden="true"></i>
                    @else
                        <a href="{{ url('/posts/elevate/'.$post->id) }}" class = "iconLink"><i class="fa fa-heart-o fa-lg" aria-hidden="true"></i></a>
                    @endif
                    <span class="tooltiptext">Heart to give thanks and recommend to others</span>
                </div>
                <div class = "leftCounter">
                    <a href={{ url('/posts/listElevation/'.$post->id)}}>{{ $post->elevation }}</a>
                </div>
            </div>

            <div class = "centerSection">
                
                <a href="{{ url('/beacons/'.$post->beacon_tag) }}">{{ $post->beacon_tag }}</a>
                <span class="tooltiptext">The Beacon for this post:  {{ $beacon->name }}</span>
            </div>

            <div class = "rightSection">
                <div class = "rightIcon">
                    <a href="{{ url('/extensions/post/'.$post->id) }}" class = "iconLink"><i class="fa fa-comments-o fa-lg" aria-hidden="true"></i></a>
                    <span class="tooltiptext">Extend to add any inspiration you received</span>
                </div>
                <div class = "rightCounter">
                    <a href={{ url('/extensions/post/list/'.$post->id)}}>{{ $post->extension }}</a>

                </div>
            </div>
            <div class = "moreSection">
                <p class = "moreOptions"><i class="fa fa-angle-up fa-lg" aria-hidden="true"></i></p>
                <div class="moreOptionsMenu">
                    <a href="{{ url('bookmarks/posts/'.$post->id) }}"><i class="fa fa-bookmark-o fa-lg" aria-hidden="true"></i></a>
                    <a href="https://www.facebook.com/share.php?u={{Request::url()}}&title={{$post->title}}" target="_blank"><i class="fa fa-facebook-square fa-lg" aria-hidden="true"></i></a>
                    <a href="https://twitter.com/intent/tweet?status={{$post->title}} - {{Request::url()}}" target="_blank"><i class="fa fa-twitter-square fa-lg" aria-hidden="true"></i></a>
                    <a href="https://plus.google.com/share?url={{Request::url()}}" target="_blank"><i class="fa fa-google-plus-square fa-lg" aria-hidden="true"></i></a>
                    @if($post->user_id != Auth::id())
                        <a href="{{ url('/intolerances/post/'.$post->id) }}"><i class="fa fa-flag-o fa-lg" aria-hidden="true"></i></a>
                    @elseif ($post->status < 1)
                        Status: Tolerant
                    @else
                        Status: Intolerant
                    @endif
                </div>
            </div>
            <div class = "linkContainer">
                @if($post->user_id == Auth::id())
                    <a href="{{ url('/posts/'.$post->id.'/edit') }}" class = "navLink">Edit</a>
                @endif

                @if($post->elevation == 0 && $post->extension == 0 && $post->user_id == $viewUser->id)
                    {!! Form::open(['method' => 'DELETE', 'route' => ['posts.destroy', $post->id], 'class' => 'formBlock']) !!}
                    {!! Form::submit('Delete', ['class' => 'redButton', 'id' => 'delete']) !!}
                    {!! Form::close() !!}
                @endif
            </div>
            @if($post->safePost == true)
                <p>
                    Post is pending safe post approval.
                </p>
            @endif
            @if($beacon->stripe_plan < 1)<p>Sponsored by:</p>

                <div class = "sponsorContentLogo">
                    @if(!$sponsor == null)
                        <a href={{ url('/sponsors/click/'. $sponsor->id) }}><img src= {{ url(env('IMAGE_LINK'). $sponsor->photo_path) }} alt="{{$sponsor->name}}" ></a>
                    @else
                        <a href={{ url('/sponsors/click/1') }}><img src= "/img/tre-uniti.png" alt="tre-uniti" ></a>
                    @endif
                </div>
            @endif
            <script src="/js/lightbox.js"></script>
        </div>
    </div>
    <div>
        <button class = "showExtensions" type = "button" id = "extensionIndex">Show Extensions</button>
    </div>
    <div id = "otherExtensions">
        <div id = "listExtensions">
    <hr class = "contentSeparator" id = "contentSeparator"/>
        @include('extensions._extensionCards')
                @if($moreExtensions > 10)
                    <div class = "showAll">
                        <a href = "{{ url('/extensions/post/list/' . $post->id) }}" class = "indexLink">View all extensions ({{ $moreExtensions }})</a>
                    </div>
                @endif
        </div>
        <div class = "newExtension">
        @include ('errors.list')
        {!! Form::open(['url' => 'extensions']) !!}

            <div id = "centerTextContent">
                {!! Form::textarea('body', null, ['id' => 'createBodyText', 'placeholder' => 'Add your extension here:', 'rows' => '3', 'maxlength' => '3500']) !!}
            </div>
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
                            {!! Form::select('beacon_tag', $beacons, $lastBeacon->beacon_tag, ['class' => 'tagSelector']) !!}
                        </div>
                    </div>
                    <select name = 'source' class = 'tagSelector' required hidden>
                        <option value="Post" @if (old('source') == 'Post') selected="selected" @endif>Post</option>
                    </select>
                </div>
            </div>
        </div>

        <input type="hidden" name="type" value="Post">
        <input type="hidden" name="id" value="{{ $post->id }}">
        <div>
            <button class = "interactButton" type = "button" id = "hiddenIndex">Show Tags</button>
            {!! Form::submit('Add Extension', ['class' => 'navButton', 'id' => 'submit']) !!}
            {!! Form::close()   !!}
            <button class = "interactButton" type = "button" id = "fullScreen">Full Screen</button>
        </div>
    </div>
@stop

