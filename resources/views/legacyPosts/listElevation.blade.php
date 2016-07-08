@extends('app')
@section('siteTitle')
    Elevation of Extension
@stop

@section('centerText')
    <h2>Elevations of  <a href={{ url('/legacyPost/'. $legacyPost->id)}}>{{ $legacyPost->title }}</a></h2>
    <div class = "indexNav">
        <a href={{ url('/legacyPosts/'. $legacyPost->id)}}><button type = "button" class = "indexButton">Back</button></a>
        <a href={{ url('/legacyPosts/'. $legacyPost->id)}}><button type = "button" class = "indexButton">Total: {{ $legacyPost->elevation }}</button></a>
        <a href={{ url('/legacyPosts/list/extension/'.$legacyPost->id)}}><button type = "button" class = "indexButton">Extensions</button></a>
    </div>
    <div class = "indexLeft">
        <h4>Date</h4>
    </div>
    <div class = "indexRight">
        <h4>Elevated By</h4>
    </div>

    @foreach ($elevations as $elevation)

        <div class = "listResource">
            <div class = "indexLeft">
                <a href="{{ action('LegacyPostController@show', [$legacyPost->id])}}"><button type = "button" class = "interactButton">{{ $elevation->created_at->format('M-d-Y') }}</button></a>
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



