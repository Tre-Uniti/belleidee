@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
    <!-- You can use Open Graph tags to customize link previews.
Learn more: https://developers.facebook.com/docs/sharing/webmasters -->
    <meta property="og:url"           content= "{{ Request::url() }}"/>
    <meta property="og:type"          content="website"/>
    <meta property="og:title"         content="Belle-Idee"/>
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

    <h2>{{ $legacyPost->title }}</h2>
    <div class = "indexNav">
        <a href="{{ action('BeliefController@show', $legacyPost->belief) }}"><button type = "button" class = "indexButton">{{ $legacyPost->belief }}</button></a>

    </div>
    <button class = "interactButton" id = "hiddenIndex">More</button>
    <div class = "indexContent" id = "hiddenContent">
        <a href={{ url('legacyPosts/list/elevation/'.$legacyPost->id)}}><button type = "button" class = "indexButton">Elevations</button></a>
        <a href = {{ url('/posts/date/'.$legacyPost->created_at->format('M-d-Y')) }}><button type = "button" class = "indexButton">{{ $legacyPost->created_at->format('M-d-Y') }}</button></a>
        <a href={{ url('legacyPosts/list/extension/'.$legacyPost->id)}}><button type = "button" class = "indexButton">Extensions</button></a>

        <div class = "indexNav">
            <a href="http://www.facebook.com/share.php?u={{Request::url()}}&title={{$legacyPost->title}}" target="_blank">
                <img src="{{ asset('img/facebook.png') }}" alt="Share on Facebook"/></a>
            <a href="https://plus.google.com/share?url={{Request::url()}}" target="_blank">
                <img src="{{ asset('img/gplus.png') }}" alt="Share on Google+"/></a>
            <a href="http://twitter.com/intent/tweet?status={{$legacyPost->title}} - {{Request::url()}}" target="_blank">
                <img src="{{ asset('img/twitter.png') }}" alt="Share on Twitter"/></a>
        </div>
    </div>

    <div id = "centerTextContent">
        {!! nl2br($legacyPost->body) !!}
    </div>

@stop

@section('centerFooter')
    @if($elevation == 'Elevated')
        <a href="{{ url('/legacyPosts/'.$legacyPost->id) }}"><button type = "button" class = "navButton">{{ $elevation }}</button></a>
    @else
        <a href="{{ url('/legacyPosts/elevate/'.$legacyPost->id) }}"><button type = "button" class = "navButton">{{ $elevation }}</button></a>
    @endif
    @if($user->type > 1)
        <a href="{{ url('/legacyPosts/'.$legacyPost->id .'/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
    @endif
    @if ($user->type > 2)
        <a href="{{ url('/legacies/') }}"><button type = "button" class = "navButton">Legacies</button></a>
    @endif
    <a href="{{ url('/extensions/legacy/'. $legacyPost->id) }}"><button type = "button" class = "navButton">Extend</button></a>
@stop