@extends('auth')
@section('loginTitle')
    Register
@stop
@section('login')
        <h3>Register</h3>
            <form role="form" method="POST" action="{{ url('/auth/register') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <table align = "center">
            <tr><td><label for = "handle" class = "login">Handle</label></td>
            <td><input type="text" id = "handle" name="handle" value="{{ old('handle') }}" class = "welcomeInputText"></td>
            </tr>
            <tr><td><label for = "email" class = "login">E-Mail Address</label></td>
                    <td><input type="email" id="email" name="email" value="{{ old('email') }}" class = "welcomeInputText"></td>
            </tr>
            <tr><td><label for = "password" class = "login">Password</label></td>
                <td><input type = "password" name = "password" id = "password" class = "welcomeInputText"/></td>
            </tr>
            <tr><td><label for = "password_confirmation" class = "login">Confirm Password</label></td>
                    <td><input type="password" id = "password_confirmation" name="password_confirmation" class = "welcomeInputText"></td></tr>
            </table>
                <button type="submit" class = "navButton">Register</button>
            </form>

@stop
@section('footer')
    <h4>Guidelines:</h4>
    <p>Handle (username) can be real or anonymous, max-length (14)</p>
    <p>Passwords must be at least 8 characters long</p>
    <p><a href = "/privacy" target="_blank">Privacy Policy</a> - <a href="/terms" target="_blank">Terms of Use</a></p>
@stop

