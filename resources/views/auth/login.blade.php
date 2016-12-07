@extends('auth')
@section('pageHeader')
    <script src = "/js/social.js"></script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <meta name="google-signin-client_id" content="194631899006-slpmvh45ou17sf3ecg89vlu6o1rbtu8o.apps.googleusercontent.com.apps.googleusercontent.com">
@stop
@section('siteTitle')
    Login
@stop
@section('centerContent')

    <div>
        <div id="fb-root"></div>
        <div class="fb-login-button" data-max-rows="1" data-size="large" data-show-faces="false" data-auto-logout-link="false"></div>
        <div class="g-signin2" data-onsuccess="onSignIn"></div>
    </div>
    <h4> - Or - </h4>
    <div class = "authCard">
        <div id = "dataInput">
            <form role="form" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}

                <div class="formData {{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="formLabel">Email</label>

                    <div class="formInput">
                        <input id="email" type="email" name="email" class="welcomeInputText" value="{{ old('email') }}">
                    </div>
                </div>
                <div class="formData{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="formLabel">Password</label>

                    <div class="formInput">
                        <input id="password" type="password" class="welcomeInputText" name="password">
                    </div>
                </div>
                <div class = "formData">
                    <label for = "remember" class = "login"> Remember Me</label>
                    <input type="checkbox" id = "remember" name="remember" class = "remember">

                </div>
                <button type="submit" class = "navButton">Login</button>
            </form>
        </div>
    </div>


    <a href="{{ secure_url('/register') }}">Join now</a> - <a href="{{ url('/password/reset') }}">Reset Password</a>
@stop
