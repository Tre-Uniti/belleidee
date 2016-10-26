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
<hr class = "contentSeparator"/>
    @include('elevations._elevationCards')

@stop
@section('centerFooter')
    @include('pagination.custom-paginator', ['paginator' => $elevations])
@stop



