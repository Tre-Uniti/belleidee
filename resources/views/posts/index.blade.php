@extends('app')
@section('siteTitle')
    Discover
@stop

@section('leftSideBar')
    <div id = "leftProfile">
        <h2>{{Auth::user()->handle}}</h2>

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
@section('handle')

@stop
@section('centerMenu')
    @if (count($errors) > 0)
        @include('errors.list')
    @endif
@stop
@section('centerText')
    <section>
        @foreach ($posts as $post)
            <article>
                <h2>
                    <a href="{{ action('PostController@show', [$post->id])}}"> {{ $post->title }}</a>
                </h2>
                <div class = "body">{{ $post->elevation }}</div>
            </article>
        @endforeach

    </section>
@stop
@section('centerFooter')
    <h2>test</h2>
@stop

