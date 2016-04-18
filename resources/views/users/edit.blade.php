@extends('app')
@section('siteTitle')
    Edit User
@stop

@section('centerText')
    <div class = "errors">
        @include ('errors.list')
    </div>

    {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'patch']) !!}
    @include ('users._edit', ['submitButtonText' => 'Update User'])

@stop

