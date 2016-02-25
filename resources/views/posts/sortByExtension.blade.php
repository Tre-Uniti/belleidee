@extends('app')
@section('siteTitle')
    Extended Posts
@stop
@section('centerText')
    <div>
    <h2>Recently Extended Posts</h2>
    <table style="display: inline-block;">
        <tr>
            <td><a href={{ url('/posts/elevation')}}>Elevated</a></td>
            <td><a href={{ url('/posts/search')}}>Search</a></td>
            <td><a href={{ url('/posts')}}>New Posts</a></td>
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
                                <td><a href={{ url('/posts/extensionTime/Today')}}>Today</a></td>
                                <td><a href = {{ url('/posts/extensionTime/Month') }}>Month</a></td>
                                <td><a href={{ url('/posts/extensionTime/Year')}}>Year</a></td>
                                <td><a href={{ url('/posts/extensionTime/All')}}>All-time</a></td>
                            </tr>
                        </table>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
    <div style = "width: 50%; float: left;">
        <h4>Title</h4>
    </div>
    <div style = "width: 50%; float: right;">
        <h4>Extensions</h4>
    </div>
        @foreach ($extensions as $extension)
            <div class = "listResource">
            <div class = "listResourceLeft">
            <a href="{{ action('PostController@show', [$extension->post_id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $extension->post->title }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('ExtensionController@postList', [$extension->post_id])}}"><button type = "button" class = "interactButton">{{ $extension->post->extension }}</button></a>
            </div>
            </div>
        @endforeach
@stop
@section('centerFooter')
@stop



