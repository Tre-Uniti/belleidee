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
    <table align = "center">
        <tr>
            <th> {!! Form::label('email', 'Email') !!}</th>
        </tr>
        <tr>
            <td>{!! Form::text('email', null, ['class' => 'createAttributes', 'placeholder' => 'To whom?']) !!}</td>
            <!--{!! Form::hidden('betaToken', str_random(7), ['class' => 'createAttributes']) !!}-->
        </tr>
    </table>
    <div class = "createSubmit">
        {!! Form::submit('Send Invite', ['class' => 'navButton']) !!}
        {!! Form::close()   !!}

    </div>
@stop
