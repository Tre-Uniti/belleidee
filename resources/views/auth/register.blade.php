@extends('auth')
@section('siteTitle')
    Register
@stop
@section('centerContent')

        <div class=" authCard">
            <div id = "dataInput">
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
                            <label for = "email" class = "login">Email</label>
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
                        {!!  Form::checkbox('agreement', 'yes', null, ['class' => 'remember'])  !!}
                        <a href="/terms" class = "welcomeLink" target="_blank">Terms of Use,</a>
                        <a href = "/privacy" class = "welcomeLink" target="_blank">Privacy Policy</a>
                    </div>
                    <button type="submit" class = "navButton">Register</button>
                </form>
            </div>
        </div>

@stop
@section('footer')
    <h4>Guidelines:</h4>
    <p>Share beautiful ideas, inspirations, and experiences instead of arguing for/against beliefs</p>
@stop

