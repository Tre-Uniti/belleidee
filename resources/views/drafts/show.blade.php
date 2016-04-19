@extends('app')
@section('siteTitle')
    Show Draft
@stop

@section('centerMenu')
    <h2>{{ $draft->title }}</h2>
@stop

@section('centerText')
    <div class = "indexNav">
        <a href="{{ action('BeliefController@beliefIndex', $draft->belief) }}"><button type = "button" class = "indexButton">{{ $draft->belief }}</button></a>
        <a href="{{ url('/beacons/tags/'.$draft->beacon_tag) }}"><button type = "button" class = "indexButton">{{ $draft->beacon_tag }}</button></a>
        <a href="{{ url('/posts') }}"><button type = "button" class = "indexButton">{{ $draft->source }}</button></a>
    </div>
        <nav class = "infoNav">
            <ul>
                <li>
                    <p class = "extras">/-\</p>
                    <div class = "indexNav">
                        <a href = {{ url('/indev') }}><button type = "button" class = "indexButton">{{ $draft->created_at->format('M-d-Y') }}</button></a>
                    </div>
                </li>
            </ul>
        </nav>
    <div id = "centerTextContent">
            <p>
                {!! nl2br(e($draft->body)) !!}
            </p>
    </div>
@stop

@section('centerFooter')
    <div id = "centerFooter">
        <a href="{{ url('/drafts/convert/'. $draft->id) }}"><button type = "button" class = "navButton">Convert to Post</button></a>
        @if($draft->user_id == Auth::id())
            <a href="{{ url('/drafts/'.$draft->id.'/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
            {!! Form::open(['method' => 'DELETE', 'route' => ['drafts.destroy', $draft->id]]) !!}
            {!! Form::submit('Delete', ['class' => 'navButton', 'id' => 'delete']) !!}
            {!! Form::close() !!}
        @else
        @endif
    </div>
@stop


