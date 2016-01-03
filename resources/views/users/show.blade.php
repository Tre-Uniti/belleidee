@extends('app')
@section('siteTitle')
    Show Post
@stop

@include('users.leftSide')

@section('centerText')
    <h2>Home of {{$user->handle}}</h2>
    <a href="{{ url('/posts') }}"><button type = "button" class = "interactButton">Elevation: {{ $user->elevation }}</button></a>
    <a href="{{ url('/extensions') }}"><button type = "button" class = "interactButton">Extension: {{ $user->extension }}</button></a>
    <hr/>
    <div style = "width: 50%; float: left;">
            <h2>Inspiration</h2>
        </div>
    <div style = "width: 50%; float: right;">
            <h2>Elevated</h2>
        </div>
            <div class = "listResource">
            @foreach ($elevations as $elevation)
                    <div class = "listResource">
                        <div class = "listResourceLeft">
                            @if (isset($elevation->post_id))
                            <a href="{{ action('PostController@show', [$elevation->post_id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $elevation->post->title }}</button></a>
                            @elseif (isset($elevation->extension_id))
                                <a href="{{ action('ExtensionController@show', [$elevation->extension_id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{ $elevation->extension->title }}</button></a>
                            @endif
                        </div>
                        <div class = "listResourceRight">
                            <a href="{{ action('UserController@show', [$elevation->user_id])}}"><button type = "button" class = "interactButton">{{ $elevation->user->handle }}</button></a>
                        </div>
                    </div>
            @endforeach
        </div>
@stop

@section('centerFooter')
    <div id = "centerFooter">


    </div>
@stop

@include('posts.rightSide')

