@extends('app')
@section('siteTitle')
    Posts
@stop

@section('centerText')
    <div>
    <h2>Recent Posts</h2>
    <table style="display: inline-block;">
        <tr>
            <td><a href={{ url('/posts/elevation')}}>Elevated</a></td>
            <td><a href={{ url('/posts/search')}}>Search</a></td>
            <td><a href={{ url('/posts/extension')}}>Extended</a></td>
        </tr>
    </table>
        <div id = "centerTextContent">
            <nav class = "infoNav">
                <ul>
                    <li>
                        <p class = "extras">/-\</p>
                        <div>
                            <table align = "center">
                                <tr>
                                    <td><a href={{ url('/posts/timeFilter/Today')}}>Today</a></td>
                                    <td><a href = {{ url('/posts/timeFilter/Month') }}>Month</a></td>
                                    <td><a href={{ url('/posts/timeFilter/Year')}}>Year</a></td>
                                    <td><a href={{ url('/posts/timeFilter/All')}}>All-time</a></td>
                                </tr>
                            </table>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <div style = "width: 50%; float: left;">
        <h4>Title</h4>
    </div>
    <div style = "width: 50%; float: right;">
        <h4>User</h4>
    </div>
        @foreach ($posts as $post)
            <div class = "listResource">
            <div class = "listResourceLeft">
            <a href="{{ action('PostController@show', [$post->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $post->title }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('UserController@show', [$post->user_id])}}"><button type = "button" class = "interactButton">{{ $post->user->handle }}</button></a>
            </div>
            </div>
        @endforeach

@stop
@section('centerFooter')
@stop



