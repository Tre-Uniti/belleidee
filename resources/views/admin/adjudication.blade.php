@extends('app')
@section('siteTitle')
    Adjudication
@stop

@section('centerText')
    <div class = "errors">
        @include ('errors.list')
    </div>

    {!! Form::model($moderation, ['route' => ['moderations.update', $moderation->id], 'method' => 'patch']) !!}
    @include ('admin._adjudicate', ['submitButtonText' => 'Adjudicate'])
@stop
