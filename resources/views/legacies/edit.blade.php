@extends('app')
@section('siteTitle')
    Edit Legacy
@stop

@section('centerText')
    <h2>Edit Legacy</h2>
    <div class = "errors">
        @include ('errors.list')
    </div>

    {!! Form::model($legacy, ['route' => ['legacies.update', $legacy->id], 'method' => 'patch']) !!}
    @include ('legacies._edit', ['submitButtonText' => 'Update Legacy'])

@stop

