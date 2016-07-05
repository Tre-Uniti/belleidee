@extends('app')
@section('siteTitle')
    Edit Promotion
@stop

@section('centerText')
    <div class = "errors">
        @include ('errors.list')
    </div>

    {!! Form::model($announcement, ['route' => ['announcements.update', $announcement->id], 'method' => 'patch']) !!}
    @include ('announcements._edit', ['submitButtonText' => 'Update Announcement'])

@stop