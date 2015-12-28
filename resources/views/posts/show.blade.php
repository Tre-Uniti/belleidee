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
        <table align = "center">
            <tr>
                <th>Belief</th>
                <th>Beacon</th>
                <th>Type</th>
            </tr>
            <tr>
                <td><a href="{{ url('/posts/') }}">{{ $post->index }}</a></td>
                <td><a href="{{ url('/beacons/tags/'.$post->beacon_tag) }}">{{ $post->beacon_tag }}</a></td>
                <td><a href="{{ url('/posts') }}">{{ $post->index2 }}</a></td>
            </tr>
        </table>
    </div>

    <div id = "centerTextContent">
        <nav class = "infoNav">
            <ul>
                <li>
                    <a href = "">/-\</a>
                    <div>
                        <table align = "center">
                            <tr>
                                <th>Elevation</th>
                                <th>Created</th>
                                <th>Extension</th>
                            </tr>
                            <tr>
                                <td><a href={{ url('/indev')}}>{{ $post->elevation }}</a></td>
                                <td> <a href = {{ url('/posts/date/'.$post->created_at->format('M-d-Y')) }}>{{ $post->created_at->format('M-d-Y') }}</a></td>
                                <td><a href={{ url('/extensions/post/list/'.$post->id)}}>{{ $post->extension }}</a></td>
                            </tr>
                        </table>
                    </div>
                </li>
            </ul>
        </nav>
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
            <a href="{{ url('/home') }}"><button type = "button" class = "navButton">Report</button></a>
        @endif
        <a href="{{ url('/extensions/post/'. $post->id) }}"><button type = "button" class = "navButton">Extend</button></a>
    </div>
@stop

@include('posts.rightSide')

