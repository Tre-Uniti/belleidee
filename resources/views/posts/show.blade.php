@extends('app')
@section('siteTitle')
    Show Inspiration
@stop
@section('handle')
    {{Auth::user()->handle}}
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