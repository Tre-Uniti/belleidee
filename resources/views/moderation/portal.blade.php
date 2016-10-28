@extends('app')
@section('siteTitle')
    Moderation Portal
@stop
@section('centerText')
    <h2>Moderation Portal</h2>
    <a href="{{ url('intolerances') }}" class = "indexLink">Intolerance Reports</a>

    <hr class = "contentSeparator"/>
    @include('users._userCards')

@stop
@section('centerFooter')
    {!! $users->render() !!}
@stop


