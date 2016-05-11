@extends('app')
@section('siteTitle')
    Edit Support
@stop

@section('centerText')
    <div class = "errors">
        @include ('errors.list')
    </div>

    {!! Form::model($support, ['route' => ['supports.update', $support->id], 'method' => 'patch']) !!}
    @include ('supports._edit', ['submitButtonText' => 'Update Support Request'])

@stop
