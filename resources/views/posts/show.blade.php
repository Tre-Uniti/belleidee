@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
    <!-- You can use Open Graph tags to customize link previews.
Learn more: https://developers.facebook.com/docs/sharing/webmasters -->
    <meta property="og:url"           content= "{{ Request::url() }}"/>
    <meta property="og:type"          content="website"/>
    <meta property="og:title"         content="Belle-Idee"/>
    <meta property="og:description"   content="{{ $post->title }}"/>
    @if(isset($sourcePhotoPath) && $sourcePhotoPath != NULL)
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
    <div class = "indexNav">
            <a href="{{ action('BeliefController@beliefIndex', $post->belief) }}"><button type = "button" class = "indexButton">{{ $post->belief }}</button></a>
           <a href="{{ url('/beacons/tags/'.$post->beacon_tag) }}"><button type = "button" class = "indexButton">{{ $post->beacon_tag }}</button></a>
            <a href="{{ url('/posts/source/'. $post->source) }}"><button type = "button" class = "indexButton">{{ $post->source }}</button></a>
    </div>
    <button class = "interactButton" id = "hiddenIndex">More</button>
    <div class = "indexContent" id = "hiddenContent">
                    <a href={{ url('/posts/listElevation/'.$post->id)}}><button type = "button" class = "indexButton">Elevations</button></a>
                    <a href = {{ url('/posts/date/'.$post->created_at->format('M-d-Y')) }}><button type = "button" class = "indexButton">{{ $post->created_at->format('M-d-Y') }}</button></a>
                    <a href={{ url('/extensions/post/list/'.$post->id)}}><button type = "button" class = "indexButton">Extensions</button></a>

                <div class = "indexNav">
                    @if($post->user_id != Auth::id())
                        <a href="{{ url('/intolerances/post/'.$post->id) }}"><button type = "button" class = "indexButton">Report Intolerance</button></a>
                    @elseif ($post->status < 1)
                        <a href="{{ url('/posts/'.$post->id) }}"><button type = "button" class = "indexButton">Status: Tolerant</button></a>
                    @else
                        <a href="{{ url('/posts/'. $post->id) }}"><button type = "button" class = "indexButton">Status: Intolerant</button></a>
                    @endif
                        @if($post->lat != NULL)
                            <a href="{{ url($location) }}" target = "_blank"><button type = "button" class = "indexButton">Location</button></a>
                        @endif
                </div>
                    <div class = "indexNav">
                        <a href="http://www.facebook.com/share.php?u={{Request::url()}}&title={{$post->title}}" target="_blank">
                            <img src="{{ asset('img/facebook.png') }}" alt="Share on Facebook"/></a>
                        <a href="https://plus.google.com/share?url={{Request::url()}}" target="_blank">
                            <img src="{{ asset('img/gplus.png') }}" alt="Share on Google+"/></a>
                        <a href="http://twitter.com/intent/tweet?status={{$post->title}} - {{Request::url()}}" target="_blank">
                            <img src="{{ asset('img/twitter.png') }}" alt="Share on Twitter"/></a>
                       </div>
    </div>
    @if($type != 'txt')
        <div class = "photoContent">
            <a href={{ url('/posts/'. $post->id) }}><img src= {{ url(env('IMAGE_LINK'). $post->post_path) }} alt="{{$post->title}}"></a>
            <p>{!! nl2br(e($post->caption)) !!}</p>
        </div>
        @else
        <div id = "centerTextContent">
            {!! nl2br(e($post->body)) !!}
        </div>
    @endif
@stop

@section('centerFooter')
    <div id = "centerFooter">

        @if($post->user_id == Auth::id())
            <a href="{{ url('/posts/'.$post->id.'/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
        @else
            @if($elevation === 'Elevated')
                <a href="{{ url('/posts/'.$post->id) }}"><button type = "button" class = "navButton">{{ $elevation }}</button></a>
            @else
                <a href="{{ url('/posts/elevate/'.$post->id) }}"><button type = "button" class = "navButton">{{ $elevation }}</button></a>
            @endif
            <a href="{{ url('/bookmarks/posts/'.$post->id) }}"><button type = "button" class = "navButton">Bookmark</button></a>
        @endif
        <a href="{{ url('/extensions/post/'. $post->id) }}"><button type = "button" class = "navButton">Extend</button></a>
        @if($post->elevation == 0 && $post->extension == 0 && $post->user_id == $viewUser->id)
                {!! Form::open(['method' => 'DELETE', 'route' => ['posts.destroy', $post->id], 'class' => 'formDeletion']) !!}
                {!! Form::submit('Delete', ['class' => 'navButton', 'id' => 'delete']) !!}
                {!! Form::close() !!}
        @endif
    </div>
@stop

