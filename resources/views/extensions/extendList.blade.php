@extends('app')
@section('siteTitle')
    Extensions
@stop

@section('centerText')
    <h2>
        Extensions of <a href = "{{ url('/extensions/' . $source->id) }}">this Extension</a>
    </h2>
    <div class = "indexNav">
        <a href={{ url('/extensions/' . $source->id) }}><button type = "button" class = "indexButton">Show Extension</button></a>
        <a href={{ url('/extensions/'. $source->id)}}><button type = "button" class = "indexButton">Total: {{ $source->extension }}</button></a>
        <a href={{ url('/extensions/listElevation/'.$source->id)}}><button type = "button" class = "indexButton">Elevations</button></a>
    </div>

    <hr class = "contentSeparator"/>
    @include('extensions._extensionCards')

@stop

@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $extensions])
@stop
