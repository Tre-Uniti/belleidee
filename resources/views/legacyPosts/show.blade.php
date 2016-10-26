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
    <meta property="og:title"         content="Belle-idee"/>
    <meta property="og:description"   content="{{ $legacyPost->title }}"/>
    @if(isset($sourcePhotoPath) && $sourcePhotoPath != NULL)
        <meta property="og:image"         content="{{ url(env('IMAGE_LINK'). $sourcePhotoPath) }}"/>
    @elseif(isset($photoPath) && $photoPath != NULL)
        <meta property="og:image"         content="{{ url(env('IMAGE_LINK'). $photoPath) }}"/>
    @else
        <meta property="og:image"         content={{ url('/img/idee-med.png') }}/>
    @endif
@stop
@section('siteTitle')
    Show Legacy Post
@stop

@section('centerText')
    <div id="fb-root"></div>
    <div id = "postContent">
<article>
    <header>
        <h2>{{ $legacyPost->title }}</h2>
        <p>
            Created on <a href = {{ url('/legacyPosts/date/'.$legacyPost->created_at->format('M-d-Y')) }}>{{ $legacyPost->created_at->format('M-d-Y') }}</a>
        </p>
    </header>
    <div class = "indexNav">
        <div class = "beliefIndex">
            <a href="{{ action('BeliefController@show', $legacyPost->belief) }}"><i class="fa fa-hashtag" aria-hidden="true"></i>Legacies</a>
            <span class="tooltiptext">Legacy posts for {{ $legacyPost->belief }}</span>
        </div>
    </div>
    @if($type != 'txt')
        <div class = "photoContent">
            <p>{!! nl2br($legacyPost->caption) !!}</p>
            <div class = "postPhoto">
                <a href="{{ url(env('IMAGE_LINK'). $legacyPost->original_source_path) }}" data-lightbox="{{ $legacyPost->title }}" data-title="{{ $legacyPost->caption }}"><img src= {{ url(env('IMAGE_LINK'). $legacyPost->source_path) }} alt="{{$legacyPost->title}}" width = "99%" height = "99%"></a>
            </div>
        </div>
    @else
        <div id = "centerTextContent">
            <p class = "textContent">
                {!! nl2br($legacyPost->body) !!}
            </p>
        </div>
    @endif
    </article>
    </div>
    <div id = "postDetails">
        <div class = "footerSection">
            <div class = "leftSection">
                <div class = "leftIcon">
                    @if($legacyPost->elevationStatus === 'Elevated')
                        <i class="fa fa-heart fa-lg" aria-hidden="true"></i>
                    @else
                        <a href="{{ url('/legacyPosts/elevate/'.$legacyPost->id) }}" class = "iconLink"><i class="fa fa-heart-o fa-lg" aria-hidden="true"></i></a>
                    @endif
                    <span class="tooltiptext">Heart to give thanks and recommend to others</span>
                </div>

                <div class = "leftCounter">
                    <a href={{ url('/legacyPosts/list/elevation/'.$legacyPost->id)}}>{{ $legacyPost->elevation }}</a>
                </div>

            </div>

            <div class = "centerSection">
                <a href="{{ url('/beliefs/'.$legacyPost->belief) }}" >{{ $legacyPost->belief }}</a>
                <span class="tooltiptext">More {{ $legacyPost->belief }} Legacies</span>
            </div>

            <div class = "rightSection">
                <div class = "rightIcon">
                    <a href="{{ url('/extensions/legacy/'.$legacyPost->id) }}" class = "iconLink"><i class="fa fa-comments-o fa-lg" aria-hidden="true"></i></a>
                    <span class="tooltiptext">Extend to add any inspiration you received</span>
                </div>
                <div class = "rightCounter">
                    <a href={{ url('/legacyPosts/list/extension/'.$legacyPost->id)}}>{{ $legacyPost->extension }}</a>
                </div>
            </div>
        </div>
        </div>
    <script src="/js/lightbox.js"></script>
            <div class = "linkContainer">
                @if($user->type > 1)
                    <a href="{{ url('/legacyPosts/'.$legacyPost->id .'/edit') }}" class = "navLink">Edit</a>
                @endif
            </div>

@stop