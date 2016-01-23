@extends('app')
@section('siteTitle')
    Edit Moderation
@stop


@section('centerText')
    <div class = "errors">
        @include ('errors.list')
    </div>

    {!! Form::model($intolerance, ['route' => ['moderations.update', $intolerance->id], 'method' => 'patch']) !!}
    @include ('moderations._edit', ['submitButtonText' => 'Update Moderation'])

@stop

@section('centerFooter')
@stop
