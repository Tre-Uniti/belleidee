@extends('app')
@section('siteTitle')
    Extended Posts
@stop
@section('centerText')
    <div>
    <h2>Most Extended Posts ({{$filter}})</h2>
    <table style="display: inline-block;">
        <tr>
            <td><a href={{ url('/posts/elevationTime/'. $time)}}>Top Elevated</a></td>
            <td><a href={{ url('/posts/search')}}>Search</a></td>
            <td><a href={{ url('/posts')}}>New Posts</a></td>
        </tr>
    </table>
        <nav class = "infoNav">
            <ul>
                <li>
                    <a href = {{ url('/posts/extension') }}><p class = "extras">/Recent\</p></a>
                </li>
            </ul>
        </nav>
    </div>
    <div id = "centerTextContent">

    </div>
    <div style = "width: 50%; float: left;">
        <h4>Title</h4>
    </div>
    <div style = "width: 50%; float: right;">
        <h4>Extensions</h4>
    </div>
        @foreach ($posts as $post)
            <div class = "listResource">
            <div class = "listResourceLeft">
            <a href="{{ action('PostController@show', [$post->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $post->title }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('ExtensionController@postList', [$post->id])}}"><button type = "button" class = "interactButton">{{ $post->extension }}</button></a>
            </div>
            </div>
        @endforeach
@stop
@section('centerFooter')
    {!! $posts->render() !!}
@stop



