@extends('app')
@section('siteTitle')
    Sponsor Review
@stop

@section('centerMenu')
    <h2>{{ $sponsorRequest->name }}</h2>
@stop

@section('centerText')
    <div class = "formDataContainer">
        <div class = "formData">
            <div class = "formLabel">
                Address:
            </div>
            <div class = "formInput">
                {{ $sponsorRequest->address }}
            </div>
        </div>
        <div class = "formData">
            <div class = "formLabel">
                Country:
            </div>
            <div class = "formInput">
                {{ $sponsorRequest->country }}
            </div>
        </div>
        <div class = "formData">
            <div class = "formLabel">
                City:
            </div>
            <div class = "formInput">
                {{ $sponsorRequest->location }}
            </div>
        </div>
        <div class = "formData">
            <div class = "formLabel">
                Phone:
            </div>
            <div class = "formInput">
                {{ $sponsorRequest->phone }}
            </div>
        </div>
        <div class = "formData">
            <div class = "formLabel">
                Email:
            </div>
            <div class = "formInput">
                {{ $sponsorRequest->email }}
            </div>
        </div>
        <div class = "formData">
            <div class = "formLabel">
                Website:
            </div>
            <div class = "formInput">
                {{ $sponsorRequest->website }}
            </div>
        </div>
        <div class = "formData">
            <div class = "formLabel">
                Adult:
            </div>
            <div class = "formInput">
                {{ $sponsorRequest->adult }}
            </div>
        </div>
        <div class = "formData">
            <div class = "formLabel">
                User:
            </div>
            <div class = "formInput">
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

