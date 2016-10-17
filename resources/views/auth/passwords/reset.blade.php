@extends('auth')
@section('siteTitle')
    Reset Password
@stop
@section('login')
    @if (session('status'))
        <div class = "flash-success">
            {{ session('status') }}
        </div>
    @endif
    <div id = "dataInput">
        <form role="form" method="POST" action="{{ url('/password/reset') }}">
            {{ csrf_field() }}

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="formData{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="inputLabel">E-Mail Address</label>

                <div class="formInput">
                    <input id="email" type="email" class="welcomeInputText" name="email" value="{{ $email or old('email') }}">
                </div>
            </div>
            <div class="formData {{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="formLabel">Password</label>

                <div class="formInput">
                    <input id="password" type="password" class="welcomeInputText" name="password">
                </div>
            </div>
            <div class="formData{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <label for="password-confirm" class="formLabel">Confirm Password</label>
                <div class="formInput">
                    <input id="password-confirm" type="password" class="welcomeInputText" name="password_confirmation">
                </div>
            </div>
            <button type="submit" class="navButton">Reset Password</button>
        </form>
    </div>
@stop
@section('footer')
    <h5>You may email tre-uniti@belle-idee.org if login problems persist.</h5>
@stop
