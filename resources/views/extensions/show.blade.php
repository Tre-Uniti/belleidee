@extends('app')
@section('siteTitle')
    Show Extension
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
    <h2>{{ $extension->title }}</h2>
            <table align = "center">
                <tr>
                    <td><a href="{{ action('BeliefController@beliefIndex', $extension->belief) }}">{{ $extension->belief }}</a></td>
                    <td><a href="{{ url('/beacons/tags/'.$extension->beacon_tag) }}">{{ $extension->beacon_tag }}</a></td>
                    @if($extension->source === 'Post')
                        <td><a href="{{ url('/posts/'.$extension->post_id ) }}">{{ $extension->source }}</a></td>
                    @elseif($extension->source === 'Extension')
                        <td><a href="{{ url('/extensions/'.$extension->extenception ) }}">{{ $extension->source }}</a></td>
                    @elseif($extension->source === 'Question')
                        <td><a href="{{ url('/questions/'.$extension->question_id ) }}">{{ $extension->source }}</a></td>
                    @endif
                </tr>
            </table>

            <nav class = "infoNav">
                <ul>
                    <li>
                        <p class = "extras">/-\</p>
                        <div>
                            <table align = "center">
                                <tr>
                                    <td><a href={{ url('/extensions/listElevation/'. $extension->id)}}>Elevations</a></td>
                                    <td> <a href = {{ url('/posts/date/'.$extension->created_at->format('M-d-Y')) }}>{{ $extension->created_at->format('M-d-Y') }}</a></td>
                                    <td><a href={{ url('/extensions/extend/list/'.$extension->id)}}>Extensions</a></td>
                                </tr>
                                <tr>
                                    <td><!-- Your Facebook share button code -->
                                        <div class="fb-share-button" data-href="{{ Request::url() }}" data-layout="button"></div></td>
                                    @if($extension->user_id != Auth::id())
                                        <td><a href="{{ url('/intolerances/extension/'.$extension->id) }}">Report Intolerance</a></td>
                                    @elseif ($extension->status < 1)
                                        <td><a href="{{ url('/extensions/'.$extension->id) }}">Status: Tolerant</a></td>
                                    @else
                                        <td><a href="{{ url('/extensions/'. $extension->id) }}">Status: Intolerant</a></td>
                                    @endif
                                    <td> <!-- Twitter share button code -->
                                        <a href="{{ Request::url() }}" class="twitter-share-button">Tweet</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </li>
                </ul>
            </nav>
    <div id = "centerTextContent">
            {!! nl2br(e($extension->body)) !!}
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

    </div>
@stop


