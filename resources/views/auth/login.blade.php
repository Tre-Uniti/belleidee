@extends('auth')
@section('siteTitle')
    Login
@stop
@section('centerContent')
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
    <hr/>
    <a href="{{ secure_url('/register') }}">Join now</a> - <a href="{{ url('/password/reset') }}">Reset Password</a>
@stop
