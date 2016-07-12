@extends('app')
@section('siteTitle')
    Extended By
@stop

@section('centerText')
    <h2>Elevation of <a href={{ url('/users/'.$user->id)}}>{{$user->handle}}</a></h2>
        <div class = "indexNav">
            <a href={{ url('/users/beacons/'. $user->id)}}><button type = "button" class = "indexButton">Beacons</button></a>
            <a href={{ url('/users/'.$user->id)}}><button type = "button" class = "indexButton">Profile</button></a>
            <a href={{ url('/users/extendedBy/'. $user->id)}}><button type = "button" class = "indexButton">Extended By</button></a>
    </div>
    <div class =  "indexLeft">
        <h4>Source Title</h4>
    </div>
    <div class = "indexRight">
        <h4>Elevated By</h4>
    </div>
    @foreach ($elevations as $elevation)
        <div class = "listResource">
            <div class = "listResourceLeft">
                @if (isset($elevation->post_id))
                    <a href="{{ action('PostController@show', [$elevation->post_id])}}"><button type = "button" class = "interactButtonLeft">{{ $elevation->post->title }}</button></a>
                @elseif (isset($elevation->extension_id))
                    <a href="{{ action('ExtensionController@show', [$elevation->extension_id])}}"><button type = "button" class = "interactButtonLeft">{{ $elevation->extension->title }}</button></a>
                @elseif (isset($elevation->question_id))
                    <a href="{{ action('QuestionController@show', [$elevation->question_id])}}"><button type = "button" class = "interactButtonLeft">{{ $elevation->question->question }}</button></a>
                @elseif (isset($elevation->legacy_post_id))
                    <a href="{{ action('LegacyPostController@show', [$elevation->legacy_post_id])}}"><button type = "button" class = "interactButtonLeft">{{ $elevation->legacyPost->title }}</button></a>
                @endif
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('UserController@show', [$elevation->user_id])}}"><button type = "button" class = "interactButton">{{ $elevation->user->handle }}</button></a>
            </div>
        </div>
    @endforeach

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $elevations])
@stop