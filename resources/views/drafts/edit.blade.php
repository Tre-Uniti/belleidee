@extends('app')
@section('siteTitle')
    Edit Draft
@stop

@section('centerText')
    <div class = "errors">
        @include ('errors.list')
    </div>

    {!! Form::model($draft, ['route' => ['drafts.update', $draft->id], 'method' => 'patch']) !!}
    @include ('drafts._edit', ['submitButtonText' => 'Update Draft'])

@stop

