@extends('app')
@section('siteTitle')
    Edit Intolerance
@stop


@section('centerText')
    <div class = "errors">
        @include ('errors.list')
    </div>

    {!! Form::model($intolerance, ['route' => ['intolerances.update', $intolerance->id], 'method' => 'patch']) !!}
    @include ('intolerances._edit', ['submitButtonText' => 'Update Intolerance'])

@stop

@section('centerFooter')
@stop

@include('drafts.rightSide')