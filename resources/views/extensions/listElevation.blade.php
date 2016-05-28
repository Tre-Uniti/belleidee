@extends('app')
@section('siteTitle')
    Elevation of Extension
@stop

@section('centerText')
    <h2>Elevations of  <a href={{ url('/extensions/'. $extension->id)}}>{{ $extension->title }}</a></h2>
    <div class = "indexNav">
        <a href={{ url('/extensions/'. $extension->id)}}><button type = "button" class = "indexButton">Back</button></a>
        <a href={{ url('/extensions/'. $extension->id)}}><button type = "button" class = "indexButton">Total: {{ $extension->elevation }}</button></a>
        <a href={{ url('/extensions/extend/list/'.$extension->id)}}><button type = "button" class = "indexButton">Extensions</button></a>
    </div>
    <div class = "indexLeft">
        <h4>Date</h4>
    </div>
    <div class = "indexRight">
        <h4>Elevated By</h4>
    </div>

    @foreach ($elevations as $elevate)

        <div class = "listResource">
            <div class = "listResourceLeft">
                <a href="{{ action('ExtensionController@show', [$extension->id])}}"><button type = "button" class = "interactButton">{{ $elevate->created_at->format('M-d-Y') }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('UserController@show', [$elevate->user_id])}}"><button type = "button" class = "interactButton">{{ $elevate->user->handle }}</button></a>
            </div>
        </div>
    @endforeach

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $elevations])
@stop



