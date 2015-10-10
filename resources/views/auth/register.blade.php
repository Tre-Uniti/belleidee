@extends('app')

@section('centerValve')
                    <div class= "welcome">
                        @if (count($errors) > 0)
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                        @endif
                    <h3>Register</h3>
                            <form  role="form" method="POST" action="{{ url('/auth/register') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <label for = "handle">Handle</label>
                                    <input type="text" id = "handle" name="handle" value="{{ old('handle') }}">
                                <label for = "email">E-Mail Address </label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}">
                                <label for = "password">Password</label>
                                    <input type="password" id="password" name="password">
                                <label for = "password_confirmation">
                                    Confirm Password</label>
                                    <input type="password" id = "password_confirmation" name="password_confirmation">
                                <button type="submit">Register</button>
                            </form>
                    </div>

@endsection