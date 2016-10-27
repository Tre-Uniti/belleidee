@extends('app')
@section('siteTitle')
    Admin Portal
@stop
@section('centerText')
    <h2>Admin Portal</h2>
    <div class = "indexNav">
        <a href="{{ url('adjudications') }}"><button type = "button" class = "indexButton">Adjudications</button></a>
        <a href="{{ url('moderations') }}"><button type = "button" class = "indexButton">Moderations</button></a>
        <a href="{{ url('intolerances') }}"><button type = "button" class = "indexButton">Intolerances</button></a>
        </div>
    <div class = "indexNav">
        <a href="{{ url('/legacies') }}"><button type = "button" class = "indexButton">Legacies</button></a>
        <a href="{{ url('/questions/create') }}"><button type = "button" class = "indexButton">Questions</button></a>
        <a href="{{ url('/admin/beacon/requests') }}"><button type = "button" class = "indexButton">Beacons</button></a>
        <a href="{{ url('/admin/sponsor/requests') }}"><button type = "button" class = "indexButton">Sponsors</button></a>
    </div>

    <hr class = "contentSeparator"/>
    @include('users._userCards')

@stop
@section('centerFooter')
    {!! $users->render() !!}
@stop


