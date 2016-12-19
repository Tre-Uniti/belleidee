@extends('app')
@section('pageHeader')
    <script src = "/js/caffeine.js"></script>
    <script src = "/js/submit.js"></script>
@stop
@section('siteTitle')
    Complete Registration
@stop

@section('centerText')
    @include ('errors.list')
<h2>Confirm Registration</h2>
    {!! Form::model($user, ['route' => ['confirmation', $user->id], 'method' => 'patch']) !!}
    <div class = "authCard">
        <p>Please confirm your Belle-idee username (max. 25 letters)</p>
        <div class="formData{{ $errors->has('handle') ? ' has-error' : '' }}">
            <label for="name" class="formLabel">Username</label>
            <div class="formInput">
                <input id="name" type="text" class="welcomeInputText" name="handle" value="@if (old('handle') != null){{ old('handle') }} @else {{ $user->handle }} @endif">
            </div>
        </div>
        <div class = "formData">
            <p><a href="/terms" class = "welcomeLink" target="_blank">Terms of Use </a> |
                <a href = "/privacy" class = "welcomeLink" target="_blank">Privacy Policy</a>
            </p>
        </div>
        {!! Form::submit('Confirm', ['class' => 'navButton']) !!}
        {!! Form::close()   !!}
    </div>

@stop