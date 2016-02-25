@extends('app')
@section('siteTitle')
    Posts
@stop

@section('centerText')
    <div>
    <h2>Recently Elevated Posts</h2>
    <table style="display: inline-block;">
        <tr>
            <td><a href={{ url('/posts')}}>New Posts</a></td>
            <td><a href={{ url('/posts/search')}}>Search</a></td>
            <td><a href={{ url('/posts/extension')}}>Extended</a></td>
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
                                <td><a href={{ url('/posts/elevationTime/Today')}}>Today</a></td>
                                <td><a href = {{ url('/posts/elevationTime/Month') }}>Month</a></td>
                                <td><a href={{ url('/posts/elevationTime/Year')}}>Year</a></td>
                                <td><a href={{ url('/posts/elevationTime/All')}}>All-time</a></td>
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
        <h4>Elevated By</h4>
    </div>
        @foreach ($elevations as $elevation)

            <div class = "listResource">
            <div class = "listResourceLeft">
            <a href="{{ action('PostController@show', [$elevation->post_id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $elevation->post->title }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('UserController@show', [$elevation->user_id])}}"><button type = "button" class = "interactButton">{{ $elevation->user->handle }}</button></a>
            </div>
            </div>
        @endforeach
@stop
@section('centerFooter')
@stop



