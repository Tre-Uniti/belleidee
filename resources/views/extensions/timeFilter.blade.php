@extends('app')
@section('siteTitle')
    Extensions
@stop

@section('centerText')
    <h2>{{ $filter }} Extensions</h2>

        <div class = "indexNav">
            <a href={{ url('/extensions/elevationTime/'. $time)}}><button type = "button" class = "indexButton">Top Elevated</button></a>
            <a href={{ url('/extensions/search')}}><button type = "button" class = "indexButton">Search</button></a>
            <a href={{ url('/extensions/extensionTime/'.$time)}}><button type = "button" class = "indexButton">Most Extended</button></a>
        </div>
        <nav class = "infoNav">
            <ul>
                <li>
                    <a href = {{ url('/extensions') }}><button type = "button" class = "indexButton">Recent Extensions</button></a>
                </li>
            </ul>
        </nav>
    <div class = "indexLeft">
        <h4>Title</h4>
    </div>
    <div class = "indexRight">
        <h4>Handle</h4>
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
