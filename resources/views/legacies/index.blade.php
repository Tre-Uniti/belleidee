@extends('app')
@section('siteTitle')
    Legacies
@stop

@section('centerText')
    <h2>Legacy Directory</h2>
        <div class = "indexLeft">
            <h4>Legacy</h4>
        </div>
        <div class = "indexRight">
            <h4>Handle</h4>
        </div>

        @foreach($legacies as $legacy)
            <div class = "listResource">
                <div class = "indexLeft">
                    <a href = {{ url('/legacies/'. $legacy->id) }}><button type = "button" class = "interactButton">{{ $legacy->belief->name }}</button></a>
                </div>
                <div class = "listResourceRight">
                    <a href = {{ url('/users/'. $legacy->user->id) }}><button type = "button" class = "interactButton">{{ $legacy->user->handle }}</button></a>
                </div>
            </div>
        @endforeach
@stop

@section('centerFooter')
    @if($user->type > 2)
        <a href = {{ url('/legacies/create') }}><button type = "button" class = "navButton">Create</button></a>
    @endif
@stop



