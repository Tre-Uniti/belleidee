@extends('app')
@section('siteTitle')
    Edit
@stop


@section('centerText')
    <div class = "errors">
        @include ('errors.list')
    </div>

    {!! Form::model($question, ['route' => ['questions.update', $question->id], 'method' => 'patch']) !!}
    @include ('questions._edit', ['submitButtonText' => 'Update Draft'])

@stop

@section('centerFooter')
@stop
