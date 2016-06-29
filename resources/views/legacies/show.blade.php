@extends('app')
@section('siteTitle')
    Show Legacy
@stop


@section('centerText')
    <h2>{{ $legacy->belief->name }}</h2>
    <p>{{ $legacy->user->handle }}</p>
        <div class = "indexNav">

        </div>
@stop

@section('centerFooter')

    @if($user->type > 1)
        <a href="{{ url('/legacies/') }}"><button type = "button" class = "navButton">Legacies</button></a>
        <a href="{{ url('/legacies/'.$legacy->id .'/edit') }}"><button type = "button" class = "navButton">Edit</button></a>
    @endif
@stop