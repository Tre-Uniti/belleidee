@extends('app')
@section('siteTitle')
    Show Extension
@stop

@section('centerText')
    <div id="fb-root"></div>
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
                                        <a href="http://www.facebook.com/share.php?u={{Request::url()}}&title={{$extension->title}}" target="_blank">
                                            <img src="{{ asset('img/facebook.png') }}" alt="Share on Facebook"/></a>
                                    </td>
                                    <td>
                                        <!-- G+ share button code -->
                                        <a href="https://plus.google.com/share?url={{Request::url()}}" target="_blank">
                                            <img src="{{ asset('img/gplus.png') }}" alt="Share on Google+"/></a>
                                    </td>
                                    <td><!-- Twitter share button code -->
                                        <a href="http://twitter.com/intent/tweet?status={{$extension->title}} - {{Request::url()}}" target="_blank">
                                            <img src="{{ asset('img/twitter.png') }}" alt="Share on Twitter"/></a>
                                    </td>
                                </tr>
                                <tr>

                                    @if($extension->user_id != Auth::id())
                                        <td colspan="3"><a href="{{ url('/intolerances/extension/'.$extension->id) }}">Report Intolerance</a></td>
                                    @elseif ($extension->status < 1)
                                        <td colspan="3"><a href="{{ url('/extensions/'.$extension->id) }}">Status: Tolerant</a></td>
                                    @else
                                        <td colspan="3"><a href="{{ url('/extensions/'. $extension->id) }}">Status: Intolerant</a></td>
                                    @endif
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
            @if($extension->elevation == 0 && $extension->extension == 0 && $extension->user_id == $viewUser->id)
                {!! Form::open(['method' => 'DELETE', 'route' => ['extensions.destroy', $extension->id]]) !!}
                {!! Form::submit('Delete', ['class' => 'navButton', 'id' => 'delete']) !!}
                {!! Form::close() !!}
            @endif
    </div>
@stop


