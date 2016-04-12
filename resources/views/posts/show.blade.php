@extends('app')
@section('siteTitle')
    Show Post
@stop
@section('pageHeader')
    <script src="/js/social.js"></script>


@stop

@section('centerText')
    <div id="fb-root"></div>
    <h2>{{ $post->title }}</h2>
    <table align = "center">
        <tr>
            <td><a href="{{ action('BeliefController@beliefIndex', $post->belief) }}">{{ $post->belief }}</a></td>
            <td><a href="{{ url('/beacons/tags/'.$post->beacon_tag) }}">{{ $post->beacon_tag }}</a></td>
            <td><a href="{{ url('/posts/source/'. $post->source) }}">{{ $post->source }}</a></td>
        </tr>
    </table>
    <nav class = "infoNav">
        <ul>
            <li>
                <p class = "extras">/-\</p>
                <div>
                    <table align = "center">
                        <tr>
                            <td><a href={{ url('/posts/listElevation/'.$post->id)}}>Elevations</a></td>
                            <td> <a href = {{ url('/posts/date/'.$post->created_at->format('M-d-Y')) }}>{{ $post->created_at->format('M-d-Y') }}</a></td>
                            <td><a href={{ url('/extensions/post/list/'.$post->id)}}>Extensions</a></td>
                        </tr>
                        <tr>
                            <td><!-- Your Facebook share button code -->
                                <a href="http://www.facebook.com/share.php?u={{Request::url()}}&title={{$post->title}}"
                                   onclick="return shareSocial(this.href);">
                                    <img src="{{ asset('img/facebook.png') }}" alt="Share on Facebook"/></a>
                             </td>
                            <td>
                                <!-- G+ share button code -->
                                <a href="https://plus.google.com/share?url={{Request::url()}}"
                                   onclick="return shareSocial(this.href);">
                                    <img src="{{ asset('img/gplus.png') }}" alt="Share on Google+"/></a>
                            </td>
                            <td><!-- Twitter share button code -->
                                <a href="http://twitter.com/intent/tweet?status={{$post->title}} - {{Request::url()}}"
                                   onclick="return shareSocial(this.href)">
                                    <img src="{{ asset('img/twitter.png') }}" alt="Share on Twitter"/></a>
                            </td>
                        </tr>
                        <tr>
                        @if($post->user_id != Auth::id())
                            <td colspan="3"><a href="{{ url('/intolerances/post/'.$post->id) }}">Report Intolerance</a></td>
                        @elseif ($post->status < 1)
                            <td colspan="3"><a href="{{ url('/posts/'.$post->id) }}">Status: Tolerant</a></td>
                        @else
                            <td colspan="3"><a href="{{ url('/posts/'. $post->id) }}">Status: Intolerant</a></td>
                        @endif
                        </tr>
                    </table>
                </div>
            </li>
        </ul>
    </nav>
        <div id = "centerTextContent">
            {!! nl2br(e($post->body)) !!}
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
            <a href="{{ url('/bookmarks/posts/'.$post->id) }}"><button type = "button" class = "navButton">Bookmark</button></a>
        @endif
        <a href="{{ url('/extensions/post/'. $post->id) }}"><button type = "button" class = "navButton">Extend</button></a>
        @if($post->elevation == 0 && $post->extension == 0 && $post->user_id == $viewUser->id)
                {!! Form::open(['method' => 'DELETE', 'route' => ['posts.destroy', $post->id]]) !!}
                {!! Form::submit('Delete', ['class' => 'navButton', 'id' => 'delete']) !!}
                {!! Form::close() !!}
        @endif
    </div>
@stop

