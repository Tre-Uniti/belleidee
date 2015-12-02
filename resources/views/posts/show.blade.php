@extends('app')
@section('siteTitle')
    Show Post
@stop

@include('posts.leftSide')

@section('centerMenu')
    <h2>{{ $post->title }}</h2>
@stop

@section('centerText')
    <div>
        <table style="display: inline-block;">
            <thead>
            <tr><th>Belief</th>
            </tr>
            </thead>
            <tbody>
            <tr><td>{{ $post->index }}</td>
            </tr>
            </tbody>
        </table>

        <table style="display: inline-block;">
            <thead>
            <tr><th>Beacon</th>
            </tr>
            </thead>
            <tbody>
            <tr><td>{{ $post->belief_beacon }}</td>
            </tr>
            </tbody>
        </table>

        <table style="display: inline-block;">
            <thead>
            <tr><th>Type</th>
            </tr>
            </thead>
            <tbody>
            <tr><td>{{ $post->index2 }}</td>
            </tr>
            </tbody>
        </table>
    </div>

        <div id = "centerTextContent">
            <p>
                {!! nl2br(e($post->body)) !!}
            </p>
        </div>
@stop

@section('centerFooter')
    <div id = "centerFooter">

        @if($post->user_id == Auth::id())
            <a href="{{ url('/posts/'.$post->id.'/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
        @else
            <a href="{{ url('/posts/'.$post->id.'/edit') }}"><button type = "button" class = "navButton">Elevate</button></a>
            <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Intolerant</button></a>
        @endif
        <a href="{{ url('/extensions/post/'. $post->id) }}"><button type = "button" class = "navButton">Extend</button></a>
    </div>
@stop

@include('posts.rightSide')

