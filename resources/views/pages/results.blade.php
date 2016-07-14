@extends('app')
@section('siteTitle')
    Global Results
@stop

@section('centerText')
        <h2>Search Results for {{$type}}</h2>
        <div class = "indexNav">
              <a href={{ url('/search')}}><button type = "button" class = "indexButton">New Global Search</button></a>
        </div>
        <div class = "indexLeft">
            @if($type == 'Users')
                <h4>Handle</h4>
            @elseif($type == 'Questions')
                <h4>Question</h4>
            @elseif($type == 'Beacons' || $type == 'Sponsors')
                <h4>Name</h4>
            @else
                <h4>Title</h4>
            @endif
        </div>
        <div class = "indexRight">
            @if($type == 'Users')
                <h4>Joined</h4>
            @elseif($type == 'Questions')
                <h4>Asked By</h4>
            @elseif($type == 'Beacons')
                <h4>Beacon Tag</h4>
            @elseif($type == 'Sponsors')
                <h4>Sponsor Tag</h4>
            @elseif($type == 'Legacy')
                <h4>Belief</h4>
            @else
                <h4>User</h4>
            @endif
        </div>
    @if($type == 'Posts')
        @foreach ($results as $result)
            <div class = "listResource">
                <div class = "listResourceLeft">
                    <a href="{{ action('PostController@show', [$result->id])}}"><button type = "button" class = "interactButtonLeft">{{$result->title}}</button></a>
                </div>
                <div class = "listResourceRight">
                    <a href="{{ action('UserController@show', [$result->user_id])}}"><button type = "button" class = "interactButton">{{$result->user->handle}}</button></a>
                </div>
            </div>
        @endforeach
    @elseif($type == 'Extensions')
        @foreach ($results as $result)
            <div class = "listResource">
                <div class = "listResourceLeft">
                    <a href="{{ action('ExtensionController@show', [$result->id])}}"><button type = "button" class = "interactButtonLeft">{{$result->title}}</button></a>
                </div>
                <div class = "listResourceRight">
                    <a href="{{ action('UserController@show', [$result->user_id])}}"><button type = "button" class = "interactButton">{{$result->user->handle}}</button></a>
                </div>
            </div>
        @endforeach
    @elseif($type == 'Questions')
        @foreach ($results as $result)
            <div class = "listResource">
                <div class = "listResourceLeft">
                    <a href="{{ action('QuestionController@show', [$result->id])}}"><button type = "button" class = "interactButton">{{$result->question}}</button></a>
                </div>
                <div class = "listResourceRight">
                    <a href="{{ action('UserController@show', [$result->user_id])}}"><button type = "button" class = "interactButton">{{$result->user->handle}}</button></a>
                </div>
            </div>
        @endforeach
    @elseif($type == 'Users')
        @foreach ($results as $result)
            <div class = "listResource">
                <div class = "listResourceLeft">
                    <a href="{{ action('UserController@show', [$result->id])}}"><button type = "button" class = "interactButtonLeft">{{$result->handle}}</button></a>
                </div>
                <div class = "listResourceRight">
                    <a href="{{ action('UserController@show', [$result->id])}}"><button type = "button" class = "interactButton">{{$result->created_at->format('M-d-Y')}}</button></a>
                </div>
            </div>
        @endforeach
    @elseif($type == 'Beacons')
        @foreach ($results as $result)
            <div class = "listResource">
                <div class = "listResourceLeft">
                    <a href="{{ action('BeaconController@show', [$result->beacon_tag])}}"><button type = "button" class = "interactButtonLeft">{{$result->name}}</button></a>
                </div>
                <div class = "listResourceRight">
                    <a href="{{ action('BeaconController@show', [$result->beacon_tag])}}"><button type = "button" class = "interactButton">{{$result->beacon_tag}}</button></a>
                </div>
            </div>
        @endforeach
    @elseif($type == 'Sponsors')
        @foreach ($results as $result)
            <div class = "listResource">
                <div class = "listResourceLeft">
                    <a href="{{ action('SponsorController@show', [$result->id])}}"><button type = "button" class = "interactButtonLeft">{{$result->name}}</button></a>
                </div>
                <div class = "listResourceRight">
                    <a href="{{ action('SponsorController@show', [$result->id])}}"><button type = "button" class = "interactButton">{{$result->sponsor_tag}}</button></a>
                </div>
            </div>
        @endforeach
    @elseif($type == 'Legacy')
        @foreach ($results as $result)
            <div class = "listResource">
                <div class = "listResourceLeft">
                    <a href="{{ action('LegacyPostController@show', [$result->id])}}"><button type = "button" class = "interactButtonLeft">{{$result->title}}</button></a>
                </div>
                <div class = "listResourceRight">
                    <a href="{{ action('LegacyPostController@beliefIndex', [$result->belief])}}"><button type = "button" class = "interactButtonLeft">{{$result->belief}}</button></a>
                </div>
            </div>
        @endforeach
    @endif
@stop
@section('centerFooter')
        {!! $results->render() !!}
@stop



