@extends('login')
@section('loginTitle')
    Login
@stop
@section('login')
    @if (count($errors) > 0)
        <strong>Woooah!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li style = "color:red">{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <h3>Login</h3>
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <table class = "input">
            <tr><td><label for = "email" class = "login">E-Mail Address</label></td>
                <td><input type="text" id="email" name="email" value="{{ old('email') }}"></td>
            </tr>
            <tr><td><label for = "password" class = "login">Password</label></td>
                <td><input type = "password" name = "password" id = "password"/></td>
            </tr>
            <tr><td><label for = "remember" class = "login"></label></td>
                <td style = "color: green"><input type="checkbox" id = "remember" name="remember"> Remember Me</td></tr>
        </table>
        <button type="submit" class = "interactButton">Login</button>
    </form>

@stop
@section('footer')
    <h4>Other Options:</h4>
    <a href="{{ url('/auth/nymi') }}"><button type = "button" class = "interactButton">Nymi</button></a><br/>
    <a class="btn btn-link" href="{{ url('/password/email') }}">Forgot Your Password?</a>
@stop
