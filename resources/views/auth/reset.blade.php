@extends('auth')

@section('login')
    <h3>Reset Password</h3>
    <form role="form" method="POST" action="{{ url('/password/reset') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="token" value="{{ $token }}">

        <table align = "center">
            <tr>
                <td><label for = "email" class = "login">E-Mail Address</label></td>
            </tr>
            <tr>
                <td><input type= "email" id = "email" class = "welcomeInputText" name="email" value="{{ old('email') }}"></td>
            </tr>
            <tr>
                <td><label for = "password" class = "login">Password</label></td>
            </tr>
            <tr>
                <td><input type="password" id = "password" class = "welcomeInputText" name="password"></td>
            </tr>
            <tr>
                <td><label for = "password_confirmation" class = "login">Confirm Password</label></td>
            </tr>
            <tr>
                <td><input type="password" id = "password_confirmation" class = "welcomeInputText" name="password_confirmation"></td>
            </tr>
        </table>
        <button type="submit" class="navButton">Reset Password</button>
    </form>
@stop
@section('footer')
    <h5>You may email Zoko@belle-idee.org if login problems persist.</h5>
@stop

