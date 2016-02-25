@extends('app')
@section('siteTitle')
    Posts
@stop

@section('centerText')
    <div>
    <h2>Top Elevated Posts ({{ $filter }})</h2>
    <table style="display: inline-block;">
        <tr>
            <td><a href={{ url('/posts')}}>New Posts</a></td>
            <td><a href={{ url('/posts/search')}}>Search</a></td>
            <td><a href={{ url('/posts/extensionTime/'. $time)}}>Most Extended</a></td>
        </tr>
    </table>
    </div>
    <div id = "centerTextContent">
        <nav class = "infoNav">
            <ul>
                <li>
                    <a href = {{ url('/posts/elevation') }}><p class = "extras">/Recent\</p></a>
                </li>
            </ul>
        </nav>
    </div>
    <div style = "width: 50%; float: left;">
        <h4>Title</h4>
    </div>
    <div style = "width: 50%; float: right;">
        <h4>Elevation</h4>
    </div>
        @foreach ($posts as $post)
            <div class = "listResource">
            <div class = "listResourceLeft">
            <a href="{{ action('PostController@show', [$post->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $post->title }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('PostController@listElevation', [$post->id])}}"><button type = "button" class = "interactButton">{{ $post->elevation }}</button></a>
            </div>
            </div>
        @endforeach
@stop
@section('centerFooter')
    {!! $posts->render() !!}
@stop



