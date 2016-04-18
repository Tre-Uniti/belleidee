@extends('app')
@section('siteTitle')
    Edit Sponsor
@stop


@section('centerText')
    <div class = "errors">
        @include ('errors.list')
    </div>

    {!! Form::model($sponsor, ['route' => ['sponsors.update', $sponsor->id], 'method' => 'patch', 'files' => true]) !!}
    @include ('sponsors._form', ['submitButtonText' => 'Update Sponsor'])

@stop