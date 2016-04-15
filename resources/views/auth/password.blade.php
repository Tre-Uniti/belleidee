@extends('auth')

@section('login')
    <h3>Reset Password</h3>
    @if (session('status'))
    <div class = "flash-success">
        <table class = "formData">
            <tr>
                <td>{{ session('status') }}</td>
            </tr>
        </table>
    </div>
    @endif
    <form role="form" method="POST" action="{{ url('/password/email') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <table align = "center">
            <tr>
                <td><label for = "email" class = "login">E-Mail Address</label></td>
            </tr>
            <tr>
                <td><input type= "email" id = "email" class = "welcomeInputText" name="email" value="{{ old('email') }}"></td>
            </tr>
        </table>
        <button type="submit" class="navButton">Send Password Reset Link</button>
    </form>

@stop
@section('footer')
    <h5>You may email tre-uniti@belle-idee.org if login problems persist.</h5>
@stop