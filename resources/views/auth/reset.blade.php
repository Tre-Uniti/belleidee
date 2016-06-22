@extends('auth')
@section('siteTitle')
    Reset Password
@stop
@section('login')
    <h3>Reset Password</h3>
    <form role="form" method="POST" action="{{ url('/password/reset') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="token" value="{{ $token }}">
        <div class = "formData">
            <div class = "formLabel">
                <label for = "email" class = "login">Email</label>
            </div>
            <div class = "formInput">
                <input type= "email" id = "email" class = "welcomeInputText" name="email" value="{{ old('email') }}">
            </div>
        </div>
        <div class = "formData">
            <div class = "formLabel">
                <label for = "password" class = "login">Password</label>
            </div>
            <div class = "formInput">
                <input type="password" id = "password" class = "welcomeInputText" name="password">
            </div>
        </div>
        <div class = "formData">
            <div class = "formLabel">
                <label for = "password_confirmation" class = "login">Confirm</label>
            </div>
            <div class = "formInput">
                <input type="password" id = "password_confirmation" class = "welcomeInputText" name="password_confirmation" placeholder="Retype password">
            </div>
        </div>
        <button type="submit" class="navButton">Reset Password</button>
    </form>
@stop
@section('footer')
    <h5>You may email tre-uniti@belle-idee.org if login problems persist.</h5>
@stop

