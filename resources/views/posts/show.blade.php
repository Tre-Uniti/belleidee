@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
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

    <h2>{{ $post->title }}</h2>
    <h4>By: <a href = {{ url('/users/'. $post->user->id) }}>{{ $post->user->handle }}</a> on <a href = {{ url('/posts/date/'.$post->created_at->format('M-d-Y')) }}>{{ $post->created_at->format('M-d-Y')  }}</a></h4>
    <div class = "indexNav">


    </div>
    <div class = "indexNav">
        <p>
            <a href="{{ action('BeliefController@show', $post->belief) }}">#{{ $post->belief }}</a>

            <a href="{{ url('/posts/source/'. $post->source) }}">#{{ $post->source }}</a>
        </p>

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
            {!! nl2br($post->body) !!}
        </div>
    @endif
@stop

@section('centerFooter')
    <div id = "centerFooter">
        <div class = "influenceSection">
            <div class = "elevationSection">
                <div class = "elevationIcon">
                    @if($post->elevateStatus === 'Elevated')
                        <img src = '/img/elevated.png'>
                    @else
                        <a href="{{ url('/posts/elevate/'.$post->id) }}"><img src = '/img/elevate.png'></a>
                    @endif
                    <span class="tooltiptext">Elevate to give thanks and recommend to others</span>
                </div>
                <div class = "elevationCounter">
                    <a href={{ url('/posts/listElevation/'.$post->id)}}>{{ $post->elevation }}</a>
                </div>
            </div>

            <div class = "beaconSection">
                <a href="{{ url('/beacons/'.$post->beacon_tag) }}">{{ $post->beacon_tag }}</a>
                <span class="tooltiptext">The Beacon for this post:  {{ $beacon->name }}</span>
            </div>

            <div class = "extensionSection">
                <a href="{{ url('/extensions/post/'.$post->id) }}"><img src = '/img/extend.png'></a>
                <a href={{ url('/extensions/post/list/'.$post->id)}}>{{ $post->extension }}</a>
                <span class="tooltiptext">Extend to add any inspiration you received</span>
            </div>


            @if($beacon->stripe_plan < 1)<p>Sponsored by:</p>

                <div class = "sponsorContentLogo">

                    <a href={{ url('/sponsors/click/'. $sponsor->id) }}><img src= {{ url(env('IMAGE_LINK'). $sponsor->photo_path) }} alt="{{$sponsor->name}}" ></a>
                </div>
            @endif


        </div>
        @if($post->user_id == Auth::id())
            <a href="{{ url('/posts/'.$post->id.'/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
        @endif

        @if($post->elevation == 0 && $post->extension == 0 && $post->user_id == $viewUser->id)
                {!! Form::open(['method' => 'DELETE', 'route' => ['posts.destroy', $post->id], 'class' => 'formDeletion']) !!}
                {!! Form::submit('Delete', ['class' => 'navButton', 'id' => 'delete']) !!}
                {!! Form::close() !!}
        @endif
    </div>




    <script src="/js/lightbox.js"></script>
@stop

