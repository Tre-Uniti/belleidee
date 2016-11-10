@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
    <link href="/css/lightbox.css" rel="stylesheet">
@stop
@section('siteTitle')
    Show Draft
@stop

@section('centerText')
    <article>
        <header>
            <h1>{{ $draft->title }}</h1>
        </header>

        <h4>By: <a href = "{{ url('/users/'. $draft->user->id) }}" class = "contentHandle" >{{ $draft->user->handle }}</a> on <a href = {{ url('/posts/date/'.$draft->created_at->format('M-d-Y')) }}>{{ $draft->created_at->format('M-d-Y')  }}</a></h4>
        <div class = "indexNav">

        </div>
        <div class = "indexNav">
            <div class = "beliefIndex">
                <a href="{{ action('BeliefController@show', $draft->belief) }}"><i class="fa fa-hashtag" aria-hidden="true"></i>{{ $draft->belief }}</a>
                <span class="tooltiptext">Belief or way of life related to the post</span>
            </div>
            <div class = "sourceIndex">
                <a href="{{ url('/posts/source/'. $draft->source) }}"><i class="fa fa-hashtag" aria-hidden="true"></i>{{ $draft->source }}</a>
                <span class="tooltiptext">Source where the post came from</span>
            </div>

        </div>

        @if($type != 'txt')
            <div class = "photoContent">
                <p>{!! nl2br($draft->caption) !!}</p>
                <div class = "postPhoto">
                    <a href="{{ url(env('IMAGE_LINK'). $sourceOriginalPath) }}" data-lightbox="{{ $draft->title }}" data-title="{{ $draft->caption }}"><img src= {{ url(env('IMAGE_LINK'). $draft->draft_path) }} alt="{{$draft->title}}" width = "99%" height = "99%"></a>
                </div>
            </div>
        @else
            <div id = "centerTextContent">
                <p class = "test">
                    {!! nl2br($draft->body) !!}
                </p>
            </div>
        @endif
    </article>
@stop

@section('centerFooter')
    <div id = "centerFooter">
        <a href="{{ url('/drafts/convert/'. $draft->id) }}"><button type = "button" class = "navButton">Convert to Post</button></a>
        @if($draft->user_id == Auth::id())
            <a href="{{ url('/drafts/'.$draft->id.'/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
            {!! Form::open(['method' => 'DELETE', 'route' => ['drafts.destroy', $draft->id], 'class' => 'formDeletion']) !!}
            {!! Form::submit('Delete', ['class' => 'redButton', 'id' => 'delete']) !!}
            {!! Form::close() !!}
        @else
        @endif
    </div>
    <script src="/js/lightbox.js"></script>
@stop


