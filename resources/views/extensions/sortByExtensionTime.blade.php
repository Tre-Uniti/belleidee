@extends('app')
@section('siteTitle')
    Most Extended
@stop

@section('centerText')
    <h2>Most Extended Extensions ({{ $filter }})</h2>
        <div class = "indexNav">
            <a href={{ url('/extensions/elevationTime/'. $time)}}><button type = "button" class = "indexButton">Top Elevated</button></a>
            <a href={{ url('/extensions/search')}}><button type = "button" class = "indexButton">Search</button></a>
            <a href={{ url('/extensions')}}><button type = "button" class = "indexButton">Recent</button></a>
        </div>
        <nav class = "infoNav">
            <ul>
                <li>
                    <a href = {{ url('/extensions/extension') }}><button type = "button" class = "indexButton">Recently Extended</button></a>
                </li>
            </ul>
        </nav>
    <div class = "indexLeft">
        <h4>Title</h4>
    </div>
    <div class = "indexRight">
        <h4>Extensions</h4>
    </div>

    @foreach ($extensions as $extension)

        <div class = "listResource">
        <div class = "listResourceLeft">
            <a href="{{ action('ExtensionController@show', [$extension->id])}}"><button type = "button" class = "interactButtonLeft">{{ $extension->title }}</button></a>
        </div>
        <div class = "listResourceRight">
            <a href="{{ action('ExtensionController@extendList', [$extension->id])}}"><button type = "button" class = "interactButton">{{ $extension->extension }}</button></a>
        </div>
        </div>
    @endforeach

@stop

@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $extensions])
@stop
