@extends('app')
@section('siteTitle')
    Support Requests
@stop

@section('centerText')
    <h2>Recent Support Requests</h2>
    <div class = "indexNav">
      <a href="{{ url('/supports/create')}}" class = "navLink">New Support Request</a>

    </div>


    <hr class = "contentSeparator"/>
    @include('supports._supportCards')
@stop
@section('centerFooter')
    {!! $supports->render() !!}
@stop
