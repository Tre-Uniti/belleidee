@extends('auth')
@section('siteTitle')
    Register
@stop
@section('centerContent')
    <div class=" authCard">
        <div id = "dataInput">
            <form role="form" method="POST" action="{{ url('/register') }}">
                {{ csrf_field() }}
                <div class="formData{{ $errors->has('handle') ? ' has-error' : '' }}">
                    <label for="name" class="formLabel">Username</label>
                    <div class="formInput">
                        <input id="name" type="text" class="welcomeInputText" name="handle" value="{{ old('handle') }}">
                    </div>
                </div>
                <div class="formData{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="formLabel">Email</label>

                    <div class="formInput">
                        <input id="email" type="email" class="welcomeInputText" name="email" value="{{ old('email') }}">
                    </div>
                </div>
                <div class="formData{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="formLabel">Password</label>

                    <div class="formInput">
                        <input id="password" type="password" class="welcomeInputText" name="password">
                    </div>
                </div>

                <div class="formData{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <label for="password-confirm" class="formLabel">Confirm</label>

                    <div class="formInput">
                        <input id="password-confirm" type="password" class="welcomeInputText" name="password_confirmation" placeholder="Repeat Password">
                    </div>
                </div>
                <div class = "formData">
                    <div class = "formLabel">
                        <label for = "password" class = "login">I agree to the</label>
                    </div>
                    {!!  Form::checkbox('agreement', 'yes', null, ['class' => 'remember'])  !!}
                    <a href="/terms" class = "welcomeLink" target="_blank">Terms of Use,</a>
                    <a href = "/privacy" class = "welcomeLink" target="_blank">Privacy Policy</a>
                </div>
                <button type="submit" class = "navButton">Register</button>
            </form>
        </div>
        <div class = "wordLineSeparator">
            <span class = "spanWordSeparator">Or</span>
        </div>
        <div class = "socialLogin">
            <a href = "{{ url('/auth/facebook') }}" class = "btn-facebook"><span><i class="fa fa-facebook-square fa-lg" aria-hidden="true"></i> | Login with Facebook</span></a>
        </div>
    </div>
    <h4>Guidelines:</h4>
    <p>Share beautiful ideas, values, and experiences instead of arguing for or against beliefs.</p>
@stop

