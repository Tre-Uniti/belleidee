@extends('app')
@section('siteTitle')
    Sponsor Review
@stop

@section('centerMenu')
    <h2>{{ $sponsorRequest->name }}</h2>
@stop

@section('centerText')
    <div class = "formDataContainer">
        <div class = "formLabel">
            Country:
        </div>
        <div class = "formShowData">
            {{ $sponsorRequest->country }}
        </div>
        <div class = "formLabel">
            Address:
        </div>
        <div class = "formShowData">
            {{ $sponsorRequest->address }}
        </div>
        <div class = "formLabel">
            City:
        </div>
        <div class = "formShowData">
            {{ $sponsorRequest->city }}
        </div>
        <div class = "formLabel">
            Zip code:
        </div>
        <div class = "formShowData">
            {{ $sponsorRequest->zip }}
        </div>
        <div class = "formLabel">
            Phone:
        </div>
        <div class = "formShowData">
            {{ $sponsorRequest->phone }}
        </div>
        <div class = "formLabel">
            Email:
        </div>
        <div class = "formShowData">
            {{ $sponsorRequest->email }}
        </div>
        <div class = "formLabel">
            Website:
        </div>
        <div class = "formShowData">
            {{ $sponsorRequest->website }}
        </div>
        <div class = "formData">
            <div class = "formLabel">
                Adult:
            </div>
            <div class = "formShowData">
                {{ $sponsorRequest->adult }}
            </div>
        </div>
        <div class = "formData">
            <div class = "formLabel">
                User:
            </div>
            <div class = "formShowData">
                {{ $sponsorRequest->user->handle }}
            </div>
        </div>
    </div>
@stop

@section('centerFooter')
    <div id = "centerFooter">
        @if($user->type > 1)
            <a href="{{ url('/admin/sponsor/convert/'.$sponsorRequest->id) }}"><button type = "button" class = "navButton">Convert to Sponsor</button></a>
                {!! Form::open(['method' => 'DELETE', 'route' => ['sponsorRequests.destroy', $sponsorRequest->id]]) !!}
                {!! Form::submit('Delete', ['class' => 'navButton', 'id' => 'delete']) !!}
                {!! Form::close() !!}
        @endif
    </div>
@stop

