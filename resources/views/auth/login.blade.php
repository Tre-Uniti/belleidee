@extends('auth')
@section('siteTitle')
    Idee - Login
@stop
@section('login')
    <form role="form" method="POST" action="{{ secure_url('/auth/login') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class = "formData">
            <div class = "formLabel">
                <label for = "email" class = "login">Email</label>
            </div>
            <div class = "formInput">
                <input type="text" id="email" name="email" class = "welcomeInputText" value="{{ old('email') }}">
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
                <label for = "remember" class = "login"> Remember Me</label>
                <input type="checkbox" id = "remember" name="remember">

        </div>
        <button type="submit" class = "navButton">Login</button>
    </form>
@stop
@section('footer')
    <hr/>
    <a class="btn btn-link" href="{{ secure_url('/password/email') }}">Forgot Your Password?</a>
@stop
