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
            <tr>
                <td><a href="{{ url('/posts/') }}">{{ $post->index }}</a>
                </td>
            </tr>
        </table>

        <table style="display: inline-block;">
            <tr><td><a href="{{ url('/posts') }}">{{ $post->belief_beacon }}</a></td>
            </tr>
        </table>

        <table style="display: inline-block;">
            <tr><td><a href="{{ url('/posts') }}">{{ $post->index2 }}</a></td>
            </tr>
        </table>
    </div>
    <a href={{ url('/extensions/post/list/'.$post->id)}}><button type = "button" class = "interactButton">Extensions</button></a>
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
            @if($elevation === 'Elevated')
                <a href="{{ url('/posts/'.$post->id) }}"><button type = "button" class = "navButton">{{ $elevation }}</button></a>
            @else
                <a href="{{ url('/posts/elevate/'.$post->id) }}"><button type = "button" class = "navButton">{{ $elevation }}</button></a>
            @endif
            <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Report</button></a>
        @endif
        <a href="{{ url('/extensions/post/'. $post->id) }}"><button type = "button" class = "navButton">Extend</button></a>
    </div>
@stop

@include('posts.rightSide')

