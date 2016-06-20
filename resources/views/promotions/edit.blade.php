@extends('app')
@section('siteTitle')
    Edit Promotion
@stop

@section('centerText')
    <div class = "errors">
        @include ('errors.list')
    </div>

    {!! Form::model($promotion, ['route' => ['promotions.update', $promotion->id], 'method' => 'patch']) !!}
    @include ('promotions._edit', ['submitButtonText' => 'Update Promotion'])

@stop