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
                {{ csrf_field() }}

                <div class="formData{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="formLabel">E-Mail Address</label>
                    <div class="formInput">
                        <input id="email" type="email" class="welcomeInputText" name="email" value="{{ old('email') }}">
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
