

@extends('app')
@section('siteTitle')
    Edit Extension
@stop

@include('extensions.leftSide')

@section('centerText')
    <div class = "errors">
        @include ('errors.list')
    </div>

    {!! Form::model($extension, ['route' => ['extensions.update', $extension->id], 'method' => 'patch']) !!}
    @include ('extensions._form', ['submitButtonText' => 'Update Extension'])
    {!! Form::close()   !!}

@stop

@section('centerFooter')
@stop

@include('extensions.rightSide')