@extends('app')
@section('siteTitle')
    Edit Moderation
@stop
@section('centerText')
    <div class = "errors">
        @include ('errors.list')
    </div>

    {!! Form::model($moderation, ['route' => ['moderations.update', $moderation->id], 'method' => 'patch']) !!}
    @include ('moderations._edit', ['submitButtonText' => 'Update Moderation'])

@stop

