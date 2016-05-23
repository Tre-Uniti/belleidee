@extends('app')

@section('pageHeader')
    <script src = "/js/index.js"></script>
@stop

@section('siteTitle')
    Elevated Users
@stop

@section('centerText')
    <div>
    <h2>Recently Elevated Users</h2>
        <div class = "indexNav">
            <a href={{ url('/users')}}><button type = "button" class = "indexButton">Recent</button></a>
            <a href={{ url('/users/search')}}><button type = "button" class = "indexButton">Search</button></a>
            <a href={{ url('/users/extension')}}><button type = "button" class = "indexButton">Extended</button></a>
        </div>
            <button class = "interactButton" id = "hiddenIndex">More</button>
            <div class = "indexContent" id = "hiddenContent">
                <a href={{ url('/users/elevationTime/Today')}}><button type = "button" class = "indexButton">Today</button></a>
                <a href = {{ url('/users/elevationTime/Month') }}><button type = "button" class = "indexButton">Month</button></a>
                <a href={{ url('/users/elevationTime/Year')}}><button type = "button" class = "indexButton">Year</button></a>
                <a href={{ url('/users/elevationTime/All')}}><button type = "button" class = "indexButton">All-time</button></a>
            </div>
        </div>
    <div class = "indexLeft">
        <h4>User's Creation</h4>
    </div>
    <div class = "indexRight">
        <h4>Elevated By</h4>
    </div>
    @foreach ($elevations as $elevation)
        <div class = "listResource">
            <div class = "listResourceLeft">
                @if($elevation->post_id != NULL)
                <a href="{{ action('PostController@show', [$elevation->post_id])}}"><button type = "button" class = "interactButtonLeft">{{ $elevation->post->title }}</button></a>
                @elseif($elevation->extension_id != NULL)
                    <a href="{{ action('ExtensionController@show', [$elevation->extension_id])}}"><button type = "button" class = "interactButtonLeft">{{ $elevation->extension->title }}</button></a>
                @elseif($elevation->question_id != NULL)
                    <a href="{{ action('QuestionController@show', [$elevation->question_id])}}"><button type = "button" class = "interactButtonLeft">{{ $elevation->question->question }}</button></a>
                @endif
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('UserController@show', [$elevation->user_id])}}"><button type = "button" class = "interactButton">{{ $elevation->user->handle }}</button></a>
            </div>
        </div>
    @endforeach
@stop



