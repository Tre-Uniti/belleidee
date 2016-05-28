@extends('app')
@section('siteTitle')
    Extensions by Date
@stop

@section('centerText')
    <h2>Created: {{ $date->format('M-d-Y') }}</h2>
    <div class = "indexNav">
        <a href={{ url('/extensions/elevation')}}><button type = "button" class = "indexButton">Top Elevated</button></a>
        <a href={{ url('/extensions/search')}}><button type = "button" class = "indexButton">Search</button></a>
        <a href={{ url('/extensions/extension')}}><button type = "button" class = "indexButton">Most Extended</button></a>
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
                <a href="{{ action('ExtensionController@show', [$extensions->id])}}"><button type = "button" class = "interactButton">{{ $extensions->title }}</button></a>
            </div>
            <div class = "listResourceRight">
                <a href="{{ action('UserController@show', [$extensions->user_id])}}"><button type = "button" class = "interactButton">{{ $extensions->user->handle }}</button></a>
            </div>
        </div>
    @endforeach

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $extensions])
@stop


