@extends('app')
@section('siteTitle')
    Create Invite
@stop
@section('leftSideBar')
    <div>
        <h2>{{$user->handle}}</h2>
        <div class = "innerPhotos">
            <a href="/"><img src={{asset('img/backgroundLandscape.jpg')}} alt="idee" height = "97%" width = "85%"></a>
        </div>
    </div>
@stop
@section('centerMenu')
    @include('errors.list')
@stop
@section('centerText')
    <h2>Send <a href = {{url('/invites')}}>Invites:</a></h2>
    {!! Form::open(['url' => 'invites']) !!}
    <div class = "formInput">
           <b>{!! Form::label('email', 'Email') !!}</b>
  </div>
    <div class = "formInput">
        {!! Form::text('email', null, ['class' => 'createAttributes', 'placeholder' => 'To whom?']) !!}
    </div>

    <!--{!! Form::hidden('betaToken', str_random(7), ['class' => 'createAttributes']) !!}-->


@stop

@section('centerFooter')
    <div class = "createSubmit">
        {!! Form::submit('Send Invite', ['class' => 'navButton']) !!}
        {!! Form::close()   !!}
    </div>
@stop
