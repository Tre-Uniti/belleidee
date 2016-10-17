@extends('layouts.app')

<!-- Main Content -->
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-envelope"></i> Send Password Reset Link
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

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
                        <label for = "email" class = "login">E-Mail</label>
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
