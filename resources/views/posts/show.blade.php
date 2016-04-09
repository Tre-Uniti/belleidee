@extends('app')
@section('siteTitle')
    Show Post
@stop
@section('pageHeader')
        <!-- Load Facebook SDK for JavaScript -->
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <!-- Load Twitter script -->
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
@stop

@section('centerText')

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
                                <div class="fb-share-button" data-href="{{ Request::url() }}" data-layout="button"></div>
                             </td>
                            <td>
                                <!-- G+ share button code -->
                                <script src="https://apis.google.com/js/platform.js" async defer></script>
                                <div class="g-plus" data-action="share" data-annotation="none" data-align="left" data-width="100px;"></div>
                            </td>
                            <td><!-- Twitter share button code -->
                                <a href="{{ Request::url() }}" class="twitter-share-button">Tweet</a>
                            </td>
                        </tr>
                        <tr>
                        @if($post->user_id != Auth::id())
                            <td colspan="3"><a href="{{ url('/intolerances/post/'.$post->id) }}">Report Intolerance</a></td>
                        @elseif ($post->status < 1)
                            <td><a href="{{ url('/posts/'.$post->id) }}">Status: Tolerant</a></td>
                        @else
                            <td><a href="{{ url('/posts/'. $post->id) }}">Status: Intolerant</a></td>
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

