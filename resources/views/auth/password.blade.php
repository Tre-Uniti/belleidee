@extends('auth')
@section('siteTitle')
    Reset Password
@stop

@section('centerContent')
    <div class = "authCard">
        @if (session('status'))
            <div class = "flash-success">
                {{ session('status') }}
            </div>
        @endif
        <div id = "dataInput">
            <form role="form" method="POST" action="{{ url('/password/email') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class = "formData">
                    <div class = "formLabel">
                        <label for = "email" class = "login">Email</label>
                    </div>
                    <div class = "formInput">
                        <input type= "email" id = "email" class = "welcomeInputText" name="email" value="{{ old('email') }}">
                    </div>
                </div>
                <button type="submit" class="navButton">Reset Now</button>
            </form>
        </div>
    </div>

@stop
@section('footer')
    <h5>You may email tre-uniti@belle-idee.org if problems persist.</h5>
@stop