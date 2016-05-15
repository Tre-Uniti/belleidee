@extends('auth')
@section('siteTitle')
    Register
@stop
@section('login')
        <h3>Register</h3>
        <form role="form" method="POST" action="{{ url('/auth/register') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class = "formData">
                <div class = "formLabel">
                    <label for = "handle" class = "login">Handle</label>
                </div>
                <div class = "formInput">
                    <input type="text" id = "handle" name="handle" value="{{ old('handle') }}" class = "welcomeInputText">
                </div>
            </div>
            <div class = "formData">
                <div class = "formLabel">
                    <label for = "email" class = "login">Email Address</label>
                </div>
                <div class = "formInput">
                    <input type="email" id="email" name="email" value="{{ old('email') }}" class = "welcomeInputText">
                </div>
            </div>
            <div class = "formData">
                <div class = "formLabel">
                    <label for = "password" class = "login">Password</label>
                </div>
                <div class = "formInput">
                    <input type = "password" name = "password" id = "password" class = "welcomeInputText"/>
                </div>
            </div>
            <div class = "formData">
                <div class = "formLabel">
                    <label for = "password_confirmation" class = "login">Confirm</label>
                </div>
                <div class = "formInput">
                    <input type="password" id = "password_confirmation" name="password_confirmation" class = "welcomeInputText" placeholder="Repeat Password">
                </div>
            </div>
            <div class = "formData">
                <div class = "formLabel">
                    <label for = "password" class = "login">I agree to the</label>
                </div>
                {!!  Form::checkbox('agreement', 'yes')  !!}
                    <a href="/terms" class = "welcomeLink" target="_blank">Terms of Use,</a>
                    <a href = "/privacy" class = "welcomeLink" target="_blank">Privacy Policy</a>
            </div>
                <button type="submit" class = "navButton">Register</button>
            </form>
@stop
@section('footer')
    <h4>Guidelines:</h4>
    <p>Handle (username) can be real or anonymous, max-length (14)</p>
    <p>Passwords must be at least 8 characters long</p>
@stop

