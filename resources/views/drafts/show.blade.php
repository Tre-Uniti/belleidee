@extends('app')
@section('siteTitle')
    Show Draft
@stop

@section('centerMenu')
    <h2>{{ $draft->title }}</h2>
@stop

@section('centerText')
    <div>
        <table align = "center">
            <tr>
                <td><a href="{{ action('BeliefController@beliefIndex', $draft->index) }}">{{ $draft->index }}</a></td>
                <td><a href="{{ url('/beacons/tags/'.$draft->beacon_tag) }}">{{ $draft->beacon_tag }}</a></td>
                <td><a href="{{ url('/posts') }}">{{ $draft->index2 }}</a></td>
            </tr>
        </table>
    </div>

    <div id = "centerTextContent">
        <nav class = "infoNav">
            <ul>
                <li>
                    <p class = "extras">/-\</p>
                    <div>
                        <table align = "center">
                            <tr>
                                <td><a href={{ url('/indev')}}>Elevation</a></td>
                                <td> <a href = {{ url('/drafts/date/'.$draft->created_at->format('M-d-Y')) }}>{{ $draft->created_at->format('M-d-Y') }}</a></td>
                                <td><a href={{ url('/extensions/post/list/'.$draft->id)}}>Extension</a></td>
                            </tr>
                        </table>
                    </div>
                </li>
            </ul>
        </nav>
            <p>
                {!! nl2br(e($draft->body)) !!}
            </p>
        </div>

@stop

@section('centerFooter')
    <div id = "centerFooter">

        @if($draft->user_id == Auth::id())
            <a href="{{ url('/drafts/'.$draft->id.'/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
        @else

        @endif
        <a href="{{ url('/drafts/convert/'. $draft->id) }}"><button type = "button" class = "navButton">Convert to Post</button></a>
    </div>
@stop

@include('drafts.rightSide')

