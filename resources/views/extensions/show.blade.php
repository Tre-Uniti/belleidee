@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
    <meta property="og:description"   content="{{ $extension->title }}"/>
    @if(isset($sourcePhotoPath) && $sourcePhotoPath != NULL)
        <meta property="og:image"         content="{{ url(env('IMAGE_LINK'). $sourcePhotoPath) }}"/>
    @elseif(isset($photoPath) && $photoPath != NULL)
        <meta property="og:image"         content="{{ url(env('IMAGE_LINK'). $photoPath) }}"/>
    @else
        <meta property="og:image"         content={{ url('/img/idee-med.png') }}/>
    @endif
@stop
@section('siteTitle')
    Show Extension
@stop

@section('centerText')
    <div id="fb-root"></div>
    <h2>
        @if($sourceType == 'Post')
            Extends: <a href = "{{ url('/posts/' . $source->id) }}">{{ $source->title }}</a>
        @elseif($sourceType == 'Legacy')
            Extends: <a href = "{{ url('/legacyPosts/' . $source->id) }}">{{ $source->title }}</a>
        @elseif($sourceType == 'Question')
            Answers: <a href = "{{ url('/questions/' . $source->id) }}">{{ $source->question }}</a>
        @else
            Extends another <a href = "{{ url('/extensions/'. $source->id) }}">Extension</a>
        @endif
    </h2>
            <div class = "indexNav">
                <a href="{{ action('BeliefController@show', $extension->belief) }}" class = "indexLink">{{ $extension->belief }}</a>
                <a href="{{ url('/beacons/'.$extension->beacon_tag) }}" class = "indexLink">{{ $extension->beacon_tag }}</a>

            </div>
    <button class = "interactButton" id = "hiddenIndex">More</button>
    <div class = "indexContent" id = "hiddenContent">
        <a href={{ url('/extensions/listElevation/'. $extension->id)}}><button type = "button" class = "indexButton">Elevations</button></a>
        <a href = {{ url('/extensions/date/'.$extension->created_at->format('M-d-Y')) }}><button type = "button" class = "indexButton">{{ $extension->created_at->format('M-d-Y') }}</button></a>
        <a href={{ url('/extensions/extend/list/'.$extension->id)}}><button type = "button" class = "indexButton">Extensions</button></a>

        <div class = "indexNav">
            @if($extension->user_id != Auth::id())
                <a href="{{ url('/intolerances/extension/'.$extension->id) }}"><button type = "button" class = "indexButton">Report Intolerance</button></a>
            @elseif ($extension->status < 1)
                <a href="{{ url('/extensions/'.$extension->id) }}"><button type = "button" class = "indexButton">Status: Tolerant</button></a>
            @else
                <a href="{{ url('/extensions/'. $extension->id) }}"><button type = "button" class = "indexButton">Status: Intolerant</button></a>
            @endif
            @if($extension->lat != NULL)
                <a href="{{ url($location) }}" target = "_blank"><button type = "button" class = "indexButton">Location</button></a>
                @endif
        </div>
        <div class = "indexNav">
            <a href="http://www.facebook.com/share.php?u={{Request::url()}}&title={{$extension->title}}" target="_blank">
                <img src="{{ asset('img/facebook.png') }}" alt="Share on Facebook"/></a>
            <a href="https://plus.google.com/share?url={{Request::url()}}" target="_blank">
                <img src="{{ asset('img/gplus.png') }}" alt="Share on Google+"/></a>
            <a href="http://twitter.com/intent/tweet?status={{$extension->title}} - {{Request::url()}}" target="_blank">
                <img src="{{ asset('img/twitter.png') }}" alt="Share on Twitter"/></a>
        </div>
    </div>
    <div id = "centerTextContent">
            {{ $extension->question }}
            {!! nl2br($extension->body) !!}
    </div>

@stop

@section('centerFooter')
    <div id = "centerFooter">
        @if($extension->user_id == Auth::id())
            <a href="{{ url('/extensions/'.$extension->id.'/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
        @else
            @if($elevation === 'Elevated')
                <a href="{{ url('/extensions/'.$extension->id) }}"><button type = "button" class = "navButton">{{ $elevation }}</button></a>
            @else
                <a href="{{ url('/extensions/elevate/'.$extension->id) }}"><button type = "button" class = "navButton">{{ $elevation }}</button></a>
            @endif
            <a href="{{ url('/bookmarks/extensions/'.$extension->id) }}"><button type = "button" class = "navButton">Bookmark</button></a>
            @endif
            <a href="{{ url('/extensions/extenception/'. $extension->id) }}"><button type = "button" class = "navButton">Extend</button></a>
            @if($extension->elevation == 0 && $extension->extension == 0 && $extension->user_id == $viewUser->id)
                {!! Form::open(['method' => 'DELETE', 'route' => ['extensions.destroy', $extension->id], 'class' => 'formDeletion']) !!}
                {!! Form::submit('Delete', ['class' => 'navButton', 'id' => 'delete']) !!}
                {!! Form::close() !!}
            @endif
    </div>
@stop


