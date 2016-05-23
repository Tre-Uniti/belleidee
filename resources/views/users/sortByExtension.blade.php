@extends('app')
@section('pageHeader')
    <script src = "/js/index.js"></script>
@stop
@section('siteTitle')
    Extended Users
@stop

@section('centerText')
    <div>
    <h2>Recently Extended Users </h2>
    <div class = "indexNav">
        <a href={{ url('/users/elevation')}}><button type = "button" class = "indexButton">Elevated</button></a>
        <a href={{ url('/users/search')}}><button type = "button" class = "indexButton">Search</button></a>
        <a href={{ url('/users')}}><button type = "button" class = "indexButton">Recent</button></a>
        </div>
        <button class = "interactButton" id = "hiddenIndex">More</button>
        <div class = "indexContent" id = "hiddenContent">
            <a href={{ url('/users/extensionTime/Today')}}><button type = "button" class = "indexButton">Today</button></a>
            <a href = {{ url('/users/extensionTime/Month') }}><button type = "button" class = "indexButton">Month</button></a>
            <a href={{ url('/users/extensionTime/Year')}}><button type = "button" class = "indexButton">Year</button></a>
            <a href={{ url('/users/extensionTime/All')}}><button type = "button" class = "indexButton">All-time</button></a>
        </div>
    </div>

    <div class = "indexLeft">
        <h4>User's Creation</h4>
    </div>
    <div class = "indexRight">
        <h4>Extended By</h4>
    </div>
    @foreach ($extensions as $extension)
        <div class = "listResource">
            <div class = "listResourceLeft">
                @if($extension->extenception != NULL)
                    <a href="{{ action('ExtensionController@show', [$extension->extenception])}}"><button type = "button" class = "interactButtonLeft">{{ $extension->extenceptionTitle($extension->extenception) }}</button></a>
                @elseif($extension->post_id != NULL)
                    <a href="{{ action('PostController@show', [$extension->post_id])}}"><button type = "button" class = "interactButtonLeft">{{ $extension->post->title }}</button></a>
                @elseif($extension->question_id != NULL)
                    <a href="{{ action('QuestionController@show', [$extension->question_id])}}"><button type = "button" class = "interactButtonLeft">{{ $extension->question->question}}</button></a>
                @endif

            </div>
            <div class = "listResourceRight">
                <a href="{{ action('UserController@show', [$extension->user_id])}}"><button type = "button" class = "interactButton">{{ $extension->user->handle }}</button></a>
            </div>
        </div>
    @endforeach
@stop



