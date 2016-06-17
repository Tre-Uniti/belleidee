@extends('app')
@section('siteTitle')
    Edit Belief
@stop

@section('centerText')
    <div class = "errors">
        @include ('errors.list')
    </div>

    {!! Form::model($belief, ['route' => ['beliefs.update', $belief->id], 'method' => 'patch']) !!}
    @include ('beliefs._edit', ['submitButtonText' => 'Update Belief'])

@stop