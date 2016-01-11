@extends('app')
@section('siteTitle')
    Edit
@stop


@section('centerText')
    <div class = "errors">
        @include ('errors.list')
    </div>

    {!! Form::model($beacon, ['route' => ['beacons.update', $beacon->id], 'method' => 'patch']) !!}
    @include ('beacons._form', ['submitButtonText' => 'Update Beacon'])

@stop

@section('centerFooter')
@stop

@include('posts.rightSide')