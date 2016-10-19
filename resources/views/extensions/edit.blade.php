@extends('app')
@section('siteTitle')
    Edit Extension
@stop
@section('centerText')
    <div class = "errors">
        @include ('errors.list')
    </div>
    {!! Form::model($extension, ['route' => ['extensions.update', $extension->id], 'method' => 'patch']) !!}
    @include ('extensions._edit', ['submitButtonText' => 'Update Extension'])
@stop