@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
    <link href="/css/lightbox.css" rel="stylesheet">
@stop
@section('siteTitle')
    Show Draft
@stop

@section('centerMenu')
    <h2>{{ $draft->title }}</h2>
@stop

@section('centerText')
    <div class = "indexNav">
        <a href="{{ action('BeliefController@show', $draft->belief) }}"><button type = "button" class = "indexButton">{{ $draft->belief }}</button></a>
        <a href="{{ url('/beacons/'.$draft->beacon_tag) }}"><button type = "button" class = "indexButton">{{ $draft->beacon_tag }}</button></a>
        <a href="{{ url('/posts') }}"><button type = "button" class = "indexButton">{{ $draft->source }}</button></a>
    </div>
    <button class = "interactButton" id = "hiddenIndex">More</button>
    <div class = "indexContent" id = "hiddenContent">
        <button type = "button" class = "indexButton">{{ $draft->created_at->format('M-d-Y') }}</button>
        </div>
        @if($type != 'txt')
            <div class = "photoContent">
                <img src="{!! $base64 !!}">
                <p>{!! nl2br($draft->caption) !!}</p>

            </div>
        @else
            <div id = "centerTextContent">
                {!! nl2br($draft->body) !!}
            </div>
        @endif
@stop

@section('centerFooter')
    <div id = "centerFooter">
        <a href="{{ url('/drafts/convert/'. $draft->id) }}"><button type = "button" class = "navButton">Convert to Post</button></a>
        @if($draft->user_id == Auth::id())
            <a href="{{ url('/drafts/'.$draft->id.'/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
            {!! Form::open(['method' => 'DELETE', 'route' => ['drafts.destroy', $draft->id], 'class' => 'formDeletion']) !!}
            {!! Form::submit('Delete', ['class' => 'navButton', 'id' => 'delete']) !!}
            {!! Form::close() !!}
        @else
        @endif
    </div>
@stop


