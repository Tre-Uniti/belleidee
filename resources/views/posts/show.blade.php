@extends('app')
@section('siteTitle')
    Show Inspiration
@stop

@section('leftSideBar')
    <div id = "leftProfile">
        <h1>{{Auth::user()->handle}}</h1>

        <a href="{{ url('/indev') }}"><button type = "button" class = "interactButton">Elevation: 0</button></a>
        <a href="{{ url('/indev') }}"><button type = "button" class = "navButton">Extension: 0</button></a>

        <div id = "motto">
            <p>This is your motto, it is customized by the user
                It can be your motto, or another motto you like
            <hr/>
        </div>
        <h2>Top 3</h2>

        <ul style = "text-align: left;">
            <li><a href="{{ url('/posts/create') }}"><button type = "button" class = "interactButton">Create and Post your first inspiration</button></a></li>
            <li><a href="{{ url('/posts/create') }}"><button type = "button" class = "interactButton">Post a second</button></a></li>
            <li><a href="{{ url('/posts/create') }}"><button type = "button" class = "interactButton">Post a third</button></a></li>
        </ul>
        </div>
@stop

@section('centerText')
    <h1>{{ $post->title }}</h1>

    <article>
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

        {{ $post->body }}

    </article>
@stop