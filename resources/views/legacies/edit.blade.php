@extends('app')
@section('siteTitle')
    Edit Belief
@stop

@section('centerText')
    <div class = "errors">
        @include ('errors.list')
    </div>

    {!! Form::model($legacy, ['route' => ['legacies.update', $legacy->id], 'method' => 'patch']) !!}
    @include ('legacies._edit', ['submitButtonText' => 'Update Legacy'])

@stop

