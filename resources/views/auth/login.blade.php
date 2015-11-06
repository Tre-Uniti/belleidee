@extends('auth')
@section('loginTitle')
    Login
@stop
@section('login')
    <h3>Login</h3>
    <form role="form" method="POST" action="{{ url('/auth/login') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <table class = "input" align = "center">
            <tr><td><label for = "email" class = "login">E-Mail Address</label></td>
                <td><input type="text" id="email" name="email" class = "welcomeInputText" value="{{ old('email') }}"></td>
            </tr>
            <tr><td><label for = "password" class = "login">Password</label></td>
                <td><input type = "password" name = "password" id = "password" class = "welcomeInputText"/></td>
            </tr>
            <tr><td colspan="2"><label for = "remember" class = "login"> Remember Me</label>
                <input type="checkbox" id = "remember" name="remember"></td></tr>
        </table>
        <button type="submit" class = "navButton">Login</button>
    </form>
@stop
@section('footer')
    <h4>Other Options:</h4>
    <a href="{{ url('/auth/login') }}"><button type = "button" class = "navButton">Nymi</button></a><br/>
    <a class="btn btn-link" href="{{ url('/password/email') }}">Forgot Your Password?</a>
@stop
