@extends('app')
@section('siteTitle')
    Edit Beacon
@stop

@section('centerText')
    <div class = "errors">
        @include ('errors.list')
    </div>

    {!! Form::model($beacon, ['route' => ['beacons.update', $beacon->id], 'method' => 'patch', 'files' => true]) !!}
    @include ('beacons._edit', ['submitButtonText' => 'Update Beacon'])

@stop
