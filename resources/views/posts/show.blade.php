@extends('app')
@section('siteTitle')
    Show Inspiration
@stop

@include('posts.leftSide')

@section('centerMenu')
    <h2>{{ $post->title }}</h2>

@stop

@section('centerText')



    <p style = "margin: 7px">Created on {{ $post->created_at->format('M-d-Y') }}</p>
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
    <a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Elevation: 100 300{{$post->elevation}}</button></a>
    <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Extension: 53{{$post->extension}}</button></a>
        <div id = "centerTextContent">
            <p>
                {!! nl2br(e($post->body)) !!}
            </p>

        </div>
@stop

@section('centerFooter')
    <div id = "centerFooter">
        <a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Intolerant</button></a>
        <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Extend Post</button></a>
        @if($post->user_id == Auth::id())
            <a href="{{ url('/posts/'.$post->id.'/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
            @endif
    </div>
@stop

@include('posts.rightSide')

