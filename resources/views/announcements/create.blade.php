@extends('app')
@section('siteTitle')
    Create Promotion
@stop

@section('centerText')
    @include ('errors.list')
    {!! Form::open(['url' => 'announcements']) !!}
    @include ('announcements._form', ['submitButtonText' => 'Create Announcement'])
@stop