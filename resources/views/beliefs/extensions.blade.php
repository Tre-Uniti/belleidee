@extends('app')
@section('siteTitle')
    Show Belief
@stop

@section('centerText')
    <h2>{{ $belief }} Extensions</h2>
    <div class = "indexNav">
        <a href={{ url('/beliefs/beacons/'. $belief)}}><button type = "button" class = "indexButton">Beacons</button></a>
        <a href={{ url('/beliefs/posts/'. $belief)}}><button type = "button" class = "indexButton">Posts</button></a>
        <a href={{ url('/beliefs/'. $belief)}}><button type = "button" class = "indexButton">Profile</button></a>
    </div>
    <div class = "indexLeft">
        <h4>Title</h4>
    </div>
    <div class = "indexRight">
        <h4>User</h4>
    </div>
    @foreach ($extensions as $extension)
        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('ExtensionController@show', [$extension->id])}}"><button type = "button" class = "interactButtonLeft">{{ $extension->title }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('UserController@show', [$extension->user_id])}}"><button type = "button" class = "interactButton">{{ $extension->user->handle }}</button></a>
            </div>
        </div>
    @endforeach

@stop
@section('centerFooter')
    {!! $extensions->render() !!}
@stop

