@extends('app')
@section('siteTitle')
    Show Belief
@stop


@section('centerText')
    <h2>{{ $belief->name }}</h2>
    <p>{{ $belief->description }}</p>
        <div class = "indexNav">
            <a href="{{ url('/beliefs/beacons/'. $belief->name) }}"><button type = "button" class = "indexButton">Beacons: {{ $belief->beacons }}</button></a>
            <a href="{{ url('/beliefs/posts/'.$belief->name) }}"><button type = "button" class = "indexButton">Posts: {{ $belief->posts }}</button></a>
            <a href="{{ url('/beliefs/extensions/'.$belief->name) }}"><button type = "button" class = "indexButton">Extensions: {{ $belief->extensions }}</button></a>
        </div>
@stop

@section('centerFooter')

    @if($user->type > 1)
        <a href="{{ url('/beliefs/'.$belief->id .'/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
    @endif
@stop