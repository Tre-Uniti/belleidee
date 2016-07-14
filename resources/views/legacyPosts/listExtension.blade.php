@extends('app')
@section('siteTitle')
    Elevation of Extension
@stop

@section('centerText')
    <h2>Extensions of  <a href={{ url('/legacyPosts/'. $legacyPost->id)}}>{{ $legacyPost->title }}</a></h2>
    <div class = "indexNav">
        <a href={{ url('/legacyPosts/list/elevation/'.$legacyPost->id)}}><button type = "button" class = "indexButton">Elevations</button></a>
        <a href={{ url('/legacyPosts/'. $legacyPost->id)}}><button type = "button" class = "indexButton">Total: {{ $legacyPost->elevation }}</button></a>
        <a href={{ url('/legacyPosts/'. $legacyPost->id)}}><button type = "button" class = "indexButton">Back</button></a>
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
    @include('pagination.custom-paginator', ['paginator' => $extensions])
@stop



