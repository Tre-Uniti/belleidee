@extends('app')
@section('siteTitle')
    Top Elevated
@stop

@section('centerText')
    <h2>Top Elevated Extensions ({{ $filter }})</h2>
    <div class = "indexNav">
        <a href={{ url('/extensions')}}><button type = "button" class = "indexButton">Recent</button></a>
        <a href={{ url('/extensions/search')}}><button type = "button" class = "indexButton">Search</button></a>
        <a href={{ url('/extensions/extensionTime/'. $time)}}><button type = "button" class = "indexButton">Most Extended</button></a>
    </div>
        <nav class = "infoNav">
            <ul>
                <li>
                    <a href = {{ url('/extensions/elevation') }}><button type = "button" class = "indexButton">Recently Elevated</button></a>
                </li>
            </ul>
        </nav>

    <div class = "indexLeft">
        <h4>Title</h4>
    </div>
    <div class = "indexRight">
        <h4>Elevation</h4>
    </div>
    @foreach ($extensions as $extension)

        <div class = "listResource">
        <div class = "listResourceLeft">
            <a href="{{ action('ExtensionController@show', [$extension->id])}}"><button type = "button" class = "interactButtonLeft">{{ $extension->title }}</button></a>
        </div>
        <div class = "listResourceRight">
            <a href="{{ action('ExtensionController@show', [$extension->id])}}"><button type = "button" class = "interactButton">{{ $extension->elevation }}</button></a>
        </div>
        </div>
    @endforeach
@stop

@section('centerFooter')
    {!! $extensions->render() !!}
@stop
