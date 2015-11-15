@extends('app')
@section('siteTitle')
    Show Inspiration
@stop

@section('leftSideBar')
    <div id = "leftSide">
        <h2>{{Auth::user()->handle}}</h2>
        <div class = "innerProfileMenus">
            <a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Elevation: 0</button></a>
            <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Extension: 0</button></a>


            <p>This is your motto, it is customized by the user
                It can be your motto, or another motto you like.  What happens with a third line</p>
        </div>
        <hr/>
        <h2>Top Posts</h2>
        <div class = "innerProfileMenus">
            <ul>
                <li><a href="{{ url('/posts/create') }}"><button type = "button" class = "interactButton">Your most inspired post</button></a></li>
                <li><a href="{{ url('/posts/create') }}"><button type = "button" class = "interactButton">Your second most inspired post</button></a></li>
                <li><a href="{{ url('/posts/create') }}"><button type = "button" class = "interactButton">Your third post inspired post</button></a></li>
            </ul>
        </div>
        <hr/>
        <div class = "innerPhotos">
            <a href="/"><img src={{asset('img/backgroundPortrait.jpg')}} alt="idee" height = "95%" width = "95%"></a>
        </div>
    </div>
@stop

@section('centerMenu')
    <h1>{{ $post->title }}</h1>
    <table align = "center" cellpadding = "15">
        <thead>
        <tr><th>Indexer</th>
            <th>Beacon</th>
            <th>Indexer</th>
        </tr>
        </thead>
        <tbody>
        <tr><td>{{ $post->index }}</td>
            <td>{{ $post->belief_beacon }}</td>
            <td>{{ $post->index2 }}</td>
        </tr>
        <tr><td><a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Sources {{$post->source_path}}</button></a></td>
            <td>                    <a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Elevate: 100 300{{$post->elevation}}</button></a></td>
            <td>                    <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Extend: 53{{$post->extension}}</button></a></td>
        </tr>
        </tbody>
    </table>
@stop

@section('centerText')
        <div id = "centerTextContent">
            <p>
        {{ $post->body }}
            </p>
        </div>
@stop
@section('centerFooter')
    <div id = "centerFooter">
        <a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Intolerant</button></a>
        <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Extend Post</button></a>
    </div>
@stop

@section('rightSideBar')
    <div id = "rightSide">
        <h2>Inspired By:</h2>
        <div class = "innerProfileMenus">
            <ul>
                <li><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Handle of user 1</button></a></li>
                <li><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Handle of user 2</button></a></li>
                <li><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Handle of user 3</button></a></li>
            </ul>
        </div>
        <hr/>
        <h2>Inspires:</h2>
        <div class = "innerProfileMenus">
            <ul>
                <li><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Handle of user 4</button></a></li>
                <li><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Handle of user 5</button></a></li>
                <li><a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Handle of user 6</button></a></li>
            </ul>
        </div>
        <hr/>
        <div class = "innerPhotos">
            <a href="/"><img src={{asset('img/idee.png')}} alt="idee" height = "95%" width = "80%"></a>
        </div>
    </div>
@stop
