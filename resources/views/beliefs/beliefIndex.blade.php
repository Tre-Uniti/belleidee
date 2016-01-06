@extends('app')
@section('siteTitle')
    Index of {{ $belief }}
@stop

@section('centerText')
    <div>
    <h2>Posts of {{ $belief }}</h2>
    <table style="display: inline-block;">
        <tr>
            <td><a href={{ url('/posts/sortByElevation')}}>Top Elevated</a></td>
            <td><a href={{ url('/indev')}}>Search</a></td>
            <td><a href={{ url('/posts/sortByExtension')}}>Most Extended</a></td>
        </tr>
    </table>
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
                <a href="{{ action('BeaconController@listTagged', [$post->beacon_tag])}}"><button type = "button" class = "interactButton">{{ $post->beacon_tag }}</button></a>
            </div>
            </div>
        @endforeach


@stop
@section('centerFooter')
    {!! $posts->render() !!}
@stop

@include('posts.rightSide')


