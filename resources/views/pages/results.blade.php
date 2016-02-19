@extends('app')
@section('siteTitle')
    Global Results
@stop

@section('centerText')
    <div>
        <h2>Search Results for {{$type}}</h2>
        <table style="display: inline-block;">
            <tr>
                <td><a href={{ url('/search')}}>New Global Search</a></td>
            </tr>
        </table>
    </div>
        <div style = "width: 50%; float: left;">
            @if($type == 'Users')
                <h4>Handle</h4>
            @elseif($type == 'Questions')
                <h4>Question</h4>
            @else
                <h4>Title</h4>
            @endif
        </div>
        <div style = "width: 50%; float: right;">
            @if($type == 'Users')
                <h4>Joined</h4>
            @elseif($type == 'Questions')
                <h4>Asked By</h4>
            @else
                <h4>User</h4>
            @endif
        </div>
    @if($type == 'Posts')
        @foreach ($results as $result)
            <div class = "listResource">
                <div class = "listResourceLeft">
                    <a href="{{ action('PostController@show', [$result->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{$result->title}}</button></a>
                </div>
                <div class = "listResourceRight">
                    <a href="{{ action('UserController@show', [$result->user_id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{$result->user->handle}}</button></a>
                </div>
            </div>
        @endforeach
    @elseif($type == 'Extensions')
        @foreach ($results as $result)
            <div class = "listResource">
                <div class = "listResourceLeft">
                    <a href="{{ action('ExtensionController@show', [$result->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{$result->title}}</button></a>
                </div>
                <div class = "listResourceRight">
                    <a href="{{ action('UserController@show', [$result->user_id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{$result->user->handle}}</button></a>
                </div>
            </div>
        @endforeach
    @elseif($type == 'Questions')
        @foreach ($results as $result)
            <div class = "listResource">
                <div class = "listResourceLeft">
                    <a href="{{ action('QuestionController@show', [$result->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{$result->question}}</button></a>
                </div>
                <div class = "listResourceRight">
                    <a href="{{ action('UserController@show', [$result->user_id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{$result->user->handle}}</button></a>
                </div>
            </div>
        @endforeach
    @elseif($type == 'Users')
        @foreach ($results as $result)
            <div class = "listResource">
                <div class = "listResourceLeft">
                    <a href="{{ action('UserController@show', [$result->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{$result->handle}}</button></a>
                </div>
                <div class = "listResourceRight">
                    <a href="{{ action('UserController@show', [$result->id])}}"><button type = "button" class = "interactButton" style = "text-align: left;">{{$result->created_at->format('M-d-Y')}}</button></a>
                </div>
            </div>
        @endforeach
    @endif
@stop
@section('centerFooter')
        {!! $results->render() !!}
@stop



